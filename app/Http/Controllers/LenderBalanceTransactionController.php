<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\LenderBalance;
use App\Models\LenderBalanceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LenderBalanceTransactionController extends Controller
{
    public function historyBalance($id){
        //dd(decrypt($id));
        $balTrans = LenderBalanceTransaction::where('user_id',decrypt($id))->count();
        $trans = LenderBalanceTransaction::where('user_id',decrypt($id))->first();
        $balance = LenderBalance::where('user_id',decrypt($id))->first();
        
        if($balTrans > 0){
            $status = $trans->status;
            $datas = LenderBalanceTransaction::where('user_id',decrypt($id))
                ->select(
                'lender_balance_transactions.*'
                )
                ->orderBy('id','desc')
                ->get();
        }else{
           return redirect()->back()->with('status','Belum Ada Transaksi Topup');
        }
        return view('lenders.history_balance',compact('status','datas','balance'));
    }

    public function cashinBalance(Request $request,$id){
        $user_id = decrypt($id);
        $lender_id = Lender::where('user_id',$user_id)->first()->id;
        $topup_amount = $request->cashin_amount;

        DB::beginTransaction();
        try {
            $createTopup = LenderBalanceTransaction::create([
                'trans_type' => 'cash in',
                'user_id' => $user_id,
                'lender_id' => $lender_id,
                'amount' => $topup_amount
            ]);
        
            DB::commit();
            return redirect('/lender/balance/history/'.encrypt($user_id))->with('status','Sukses Request Cash In, Silahkan tunggu admin kami akan cek transaksi anda');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return redirect()->back()->with(['status' => 'Gagal Cash In, Silahkan hubungi Admin']);
        }
        //dd($lender_id);
    }

    public function cashoutBalance(Request $request,$id){
        $user_id = decrypt($id);
        $lender_id = Lender::where('user_id',$user_id)->first()->id;
        $topup_amount = str_replace(",", "",$request->cashout_amount);

        //cek dulu ke saldo
        $cekBal = LenderBalance::where('lender_id',$lender_id)->first()->balance;
        if ($cekBal < $topup_amount) {
            return redirect()->back()->with(['status' => 'Saldo Anda Tidak Mencukupi']);
        }

        DB::beginTransaction();
        try {
            $createTopup = LenderBalanceTransaction::create([
                'trans_type' => 'cash out',
                'user_id' => $user_id,
                'lender_id' => $lender_id,
                'amount' => $topup_amount
            ]);

            $balance = LenderBalance::where('lender_id', $lender_id)->first()->balance;
            $balance = $balance - $topup_amount;

            $updateBal = LenderBalance::where('lender_id',$lender_id)
                ->update([
                    'balance' => $balance
                ]);
        
            DB::commit();
            return redirect('/lender/balance/history/'.encrypt($user_id))->with('status','Sukses Request Cash Out, Silahkan tunggu admin kami akan cek transaksi anda');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return redirect()->back()->with(['status' => 'Gagal Cash Out, Silahkan hubungi Admin']);
        }
        //dd($lender_id);
    }

    public function approvedBalance($id){
        //dd(decrypt($id));
        DB::beginTransaction();
        try {
            $approved = LenderBalanceTransaction::where('id',decrypt($id))
            ->update([
                'status' => 'approved',
                'settled_by' => auth()->user()->id,
                'settled_date' => now()
            ]);

            $balTrans = LenderBalanceTransaction::where('id',decrypt($id))->first();
            if ($balTrans->trans_type == 'cash in') {
                $balance = LenderBalance::where('lender_id', $balTrans->lender_id)->first()->balance;
                $balance = $balance + $balTrans->amount;

                $updateBal = LenderBalance::where('lender_id',$balTrans->lender_id)
                    ->update([
                        'balance' => $balance
                    ]);
            }
        
            DB::commit();
            return redirect()->back()->with('status','Sukses Approved Cash In Transaction');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return redirect()->back()->with(['status' => 'Gagal Approved Cash In Transaction']);
        }
    }

    public function rejectedBalance($id){
        DB::beginTransaction();
        try {
            $approved = LenderBalanceTransaction::where('id',decrypt($id))
            ->update([
                'status' => 'rejected',
                'settled_by' => auth()->user()->id,
                'settled_date' => now()
            ]);

            DB::commit();
            return redirect()->back()->with('status','Sukses Rejected Cash In Transaction');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return redirect()->back()->with(['status' => 'Gagal Rejected Cash In Transaction']);
        }
    }
}
