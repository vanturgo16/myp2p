<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Lender;
use App\Models\LenderBalance;
use App\Models\LenderBalanceTransaction;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Loan::select(
            'borrowers.*',
            'loans.*',
            'loan_products.*',
            'loans.id as loan_id',
            'loans.created_at as tgl_pinjam'
        )
        ->whereIn('loans.status',['approved', 'funded', 'disbursed', 'paid'])
        ->leftJoin('borrowers','loans.borrower_id','borrowers.id')
        ->leftJoin('loan_products','loans.loan_product_id','loan_products.id')
        ->orderBy('loans.id','desc')->get();
        
        $lender_id = auth()->user()->id;
        $lender = Lender::leftJoin('lender_balances','lenders.user_id','lender_balances.user_id')
            ->where('lenders.user_id',$lender_id)->first();

        return view('loans.index',compact('datas','lender'));
    }

    public function loanFunded(Request $request,$loan_id){
        //cek limit
        $user_id = auth()->user()->id;
        $lender = Lender::select(
            'lenders.*',
            'lender_balances.balance'
        )
        ->leftJoin('lender_balances','lenders.user_id','lender_balances.user_id')
        ->where('lenders.user_id',$user_id)->first();

        if($lender->balance < $request->fund_amount){
            return redirect()->back()->with('fail','Saldo aktif anda tidak mencukupi untuk mendanai pinjaman ini');
        }

        DB::beginTransaction();
        try {
            //query loan
            $loan = Loan::where('id',decrypt($loan_id))->first();

            //kurangi balance
            $balance = $lender->balance - $request->fund_amount;
            $updateBalance = LenderBalance::where('lender_balances.user_id',$user_id)
                ->update([
                    'balance' => $balance
                ]);

            //update loan funded
            $loan_funded = $loan->loan_funded + $request->fund_amount;

            //apakah pendanaan sudah melewati loan amount
            if($loan_funded > $loan->loan_amount){
                return redirect()->back()->with('fail','Pinjaman sudah sepenuhnya di danai');
            }

            $updateLoanFunded = Loan::where('id',decrypt($loan_id))->update([
                'loan_funded' => $loan_funded,
                'status' => 'funded'
            ]);

            //insert transaction first
            $createBalTrans = LenderBalanceTransaction::create([
                'trans_type' => 'funding',
                'user_id' => $user_id,
                'lender_id' => $lender->id,
                'amount' => $request->fund_amount,
                'ref_no' => $loan->loan_no,
                'status' => 'pending'
            ]);
            
            $currentDate = Carbon::now()->format('Ymd');
            $updatenoTrans = LenderBalanceTransaction::where('id',$createBalTrans->id)->update([
                'trans_no' => 'FU/'.$currentDate. "/" .$createBalTrans->id,
            ]);

            DB::commit();
            return redirect()->back()->with('success','Sukses Pendanaan');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return redirect()->back()->with(['fail' => 'Gagal Pendanaan']);
        }
    }

    public function paymentList($loan_no){
        //dd(decrypt($loan_no));
        $datas = Invoice::where('loan_no',decrypt($loan_no))->get();

        return view('loans.list_payment',compact('datas'));
    }

    public function paidLoan($inv_id){
        //dd(decrypt($inv_id));
        DB::beginTransaction();
        try {
            $statusPaid = Invoice::where('id',decrypt($inv_id))
                ->update([
                    'status' => 'pending'
                ]);

            DB::commit();
            session()->flash('status', 'Sukses Pembayaran Tagihan, Admin kami akan mengecek transaksi pembayaran anda');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Pembayaran Tagihan');
            return redirect()->back();
        }  
    }

    public function paidConfirm($inv_id){
        DB::beginTransaction();
        try {
            $statusPaid = Invoice::where('id',decrypt($inv_id))
                ->update([
                    'status' => 'paid'
                ]);
            
            $invoice = Invoice::where('id',decrypt($inv_id))->first();

            //balikin dana pemodal
            $loan = Loan::where('loan_no',$invoice->loan_no)->first();
            $fundingTrans = LenderBalanceTransaction::where('ref_no',$invoice->loan_no)
                ->where('trans_type', 'funding')
                ->get();
                
            foreach ($fundingTrans as $transaction) {
                # code...
                $amount = $transaction->amount/$loan->duration_months;
                $createPay = LenderBalanceTransaction::create([
                    'trans_type' => 'payment',
                    'ref_no' => $invoice->loan_no,
                    'user_id' => $transaction->user_id,
                    'lender_id' => $transaction->lender_id,
                    'amount' => $amount,
                    'status' => 'approved',
                    'settled_by' => auth()->user()->id,
                    'settled_date' => now()
                ]);

                $currentDate = Carbon::now()->format('Ymd');
                $updatenoTrans = LenderBalanceTransaction::where('id',$createPay->id)->update([
                    'trans_no' => 'CI/'.$currentDate. "/" .$createPay->id,
                ]);

                //update balance pemodal
                $balance = LenderBalance::where('lender_id',$transaction->lender_id)->first();
                $balance = $balance->balance + $amount;

                $updateBal = LenderBalance::where('lender_id',$transaction->lender_id)
                    ->update([
                        'balance' => $balance
                    ]);
            }

            //cek sudah bayar semua inv
            $countInvoiceNotPaid = Invoice::where('loan_no',$invoice->loan_no)
                ->whereIn('status',['not paid','pending'])
                ->count();
            if($countInvoiceNotPaid < 1){
                $updateStatusLoan = Loan::where('loan_no',$invoice->loan_no)
                ->update([
                    'status' => 'paid',
                    'is_active' => '0'
                ]);
            }

            DB::commit();
            session()->flash('status', 'Sukses Konfirmasi Pembayaran Tagihan');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Konfirmasi Pembayaran Tagihan');
            return redirect()->back();
        }  
    }

    public function paidUnconfirm($inv_id){
        DB::beginTransaction();
        try {
            $statusPaid = Invoice::where('id',decrypt($inv_id))
                ->update([
                    'status' => 'not paid'
                ]);

            DB::commit();
            session()->flash('status', 'Pembayaran Tagihan Tidak terkonfirmasi');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Unconfirm Pembayaran Tagihan');
            return redirect()->back();
        }  
    }
}
