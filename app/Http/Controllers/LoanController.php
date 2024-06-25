<?php

namespace App\Http\Controllers;

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
}
