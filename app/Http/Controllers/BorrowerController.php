<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class BorrowerController extends Controller
{
    public function indexRegist()
    {
        return view('borrowers.registration');
    }

    public function historyLoan($id){
        //dd(decrypt($id));
        $borrower_id = Borrower::where('user_id',decrypt($id))->first();

        $loanCount = Loan::where('borrower_id',$borrower_id->id)->count();

        if($loanCount > 0){
            $loan = Loan::where('borrower_id',$borrower_id->id)->where('is_active','0')->orderBy('id','desc')->first();
            $status = $loan->status;
            $datas = Loan::select(
                'loans.*',
                'borrowers.*',
                'loans.id as id_loan'
                )
                ->where('borrower_id',$borrower_id->id)
                ->leftJoin('borrowers','loans.borrower_id','borrowers.id')
                ->get();
        }else{
            $status = "";
            $datas = [];
        }
        return view('borrowers.history_loan',compact('status','datas'));
    }
    
    public function createLoan($id)
    {
        //dd('hai');
        $borrower = Borrower::where('user_id',decrypt($id))->first();
        $loanProducts = LoanProduct::orderBy('product_name','asc')->orderBy('tenor','asc')->get();
        return view('borrowers.create_loan',compact('borrower','loanProducts'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {

            $storeUser = User::create([
                'name' => $request->borrower_name,
                'email' => $request->borrower_email,
                'password' => $request->borrower_password,
                'role' => 'Borrower'
            ]);

            if ($request->hasFile('borrower_id_card')) {
                //dd('hai');
                $path_loc = $request->file('borrower_id_card');
                $filename = $path_loc->getClientOriginalName();
                $extension = $path_loc->getClientOriginalExtension();
                $url = $path_loc->move('storage/id_card/borrower/', $filename);
                //dd($path_loc,$filename,$extension,$url);
            }

            $storeBorrower = Borrower::create([
                'user_id'=> $storeUser->id, 
                'borrower_name' => $request->borrower_name, 
                'gender' =>  $request->borrower_gender, 
                'borrower_address' =>  $request->borrower_address, 
                'borrower_phone' =>  trim($request->borrower_phone), 
                'borrower_occupation' =>  $request->borrower_occupation, 
                'borrower_source_income' =>  $request->borrower_source_income, 
                'borrower_income' =>  $request->borrower_income, 
                'borrower_id_card_no' =>  $request->borrower_id_card_no,
                'borrower_id_card' =>  $url->getPath()."/".$filename,
                'is_active' => '0'
            ]);

            DB::commit();
            session()->flash('status', 'Sukses Registrasi Peminjam, Silahkan Login');
            return redirect('/');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Registrasi Peminjam');
            return redirect('/');
        }
    }

    public function storeLoan(Request $request){
        $loan_amount = str_replace(",", "",$request->loan_amount);

        //cek limit
        $check = Borrower::where('id',$request->borrower_id)->first();
        if($loan_amount > $check->loan_limit){
            session()->flash('status', 'Jumlah pinjaman melebihi limit');
            return redirect()->back();
        }
        else{
            DB::beginTransaction();
            try {
                $detailProduct = LoanProduct::where('id',$request->loan_product)->first();
                $interest = $detailProduct->platform+$detailProduct->lender;
                $storeLoan = Loan::create([
                    'borrower_id' => $request->borrower_id,
                    'loan_product_id' => $request->loan_product,
                    'loan_amount' => $loan_amount,
                    'loan_purpose' => $request->loan_purpose,
                    'interest_rate' => $interest,
                    'duration_months' => $detailProduct->tenor,
                    'status' => 'pending',
                    'is_active' => '0'
                ]);

                DB::commit();
                session()->flash('status', 'Silahkan konfirmasi pengajuan pinjaman anda');
                return redirect('/borrower/loan/confirm/'.encrypt($storeLoan->id));
            } catch (\Throwable $th) {
                dd($th);
                DB::rollback();
                session()->flash('status', 'Gagal pengajuan pinjaman');
                return redirect()->back();
            }
        }
    }

    public function confirmLoan($id){
        //dd(decrypt($id));
        $borrower = Loan::select(
            'borrowers.*',
            'loans.*',
            'loans.id as loan_id',
            'loans.created_at as tgl_pinjam'
        )
            ->leftJoin('borrowers','loans.borrower_id','borrowers.id')
            ->where('loans.id',decrypt($id))
            ->first();
        
        $detailProduct = LoanProduct::where('id',$borrower->loan_product_id)->first();
        $tenor = $detailProduct->tenor;
        $tenor_type = $detailProduct->tenor_type;
        
        if ($detailProduct->type == 'advance') {
            # code...
            $amount = $borrower->loan_amount;
            $days = $detailProduct->tenor * 30;
            $admin_fee = (($detailProduct->platform * $days) * $amount)/100;
            $lender = (($detailProduct->lender * $days) * $amount)/100;
            $totalPay = $amount;
            $disburst_amount = $amount - ($admin_fee + $lender);
            $installment = $amount/$detailProduct->tenor;
        }
        else{
            $amount = $borrower->loan_amount;
            $days = $detailProduct->tenor * 30;
            $admin_fee = (($detailProduct->platform * $days) * $amount)/100;
            $lender = (($detailProduct->lender * $days) * $amount)/100;
            $totalPay = $amount + ($admin_fee + $lender);
            $disburst_amount = $amount;
            $installment = $totalPay/$detailProduct->tenor;
        }

        return view('borrowers.confirm_loan',compact(
            'borrower',
            'amount',
            'days',
            'admin_fee',
            'lender',
            'totalPay',
            'disburst_amount',
            'installment',
            'tenor',
            'tenor_type'
        ));
    }

    public function confirmSubmitLoan($id){
        //dd('hai');
        DB::beginTransaction();
        try {
            //cari loan
            $loan = Loan::where('id',decrypt($id))->first();
            //logic product
            $detailProduct = LoanProduct::where('id',$loan->loan_product_id)->first();
            if ($detailProduct->type == 'advance') {
                # code...
                $amount = $loan->loan_amount;
                $days = $detailProduct->tenor * 30;
                $totalPlatform = $detailProduct->platform * $days;
                $admin_fee = (($detailProduct->platform * $days) * $amount)/100;
                $totalLender = $detailProduct->lender * $days;
                $lender = (($detailProduct->lender * $days) * $amount)/100;
                $totalPay = $amount;
                $disburst_amount = $amount - ($admin_fee + $lender);
                $installment = $amount/$detailProduct->tenor;
            }
            else{
                $amount = $loan->loan_amount;
                $days = $detailProduct->tenor * 30;
                $totalPlatform = $detailProduct->platform * $days;
                $admin_fee = (($detailProduct->platform * $days) * $amount)/100;
                $totalLender = $detailProduct->lender * $days;
                $lender = (($detailProduct->lender * $days) * $amount)/100;
                $totalPay = $amount + ($admin_fee + $lender);
                $disburst_amount = $amount;
                $installment = $totalPay/$detailProduct->tenor;
            }

            $currentDate = Carbon::now()->format('Ymd');
            Loan::where('id',decrypt($id))->update([
                'loan_no' => 'PJM/'.$currentDate. "/" .decrypt($id),
                'platform' => $totalPlatform,
                'platform_amount' => $admin_fee,
                'lender' => $totalLender,
                'lender_amount' => $lender,
                'status' => 'approval',
                'disburst_amount' => $disburst_amount,
                'total_pay' => $totalPay
            ]);

            DB::commit();
            session()->flash('status', 'Sukses Pengajuan Pinjaman, Silahkan Tunggu Moderasi Admin');
            return redirect('/');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Pengajuan Pinjaman');
            return redirect('/');
        }
    }

    public function viewProfile($id){
        $borrower = Borrower::where('user_id',decrypt($id))->first();
        return view('borrowers.profile',compact('borrower'));
    }

    public function update(Request $request, $id)
    {
        //dd(decrypt($id));
        
        //dd($request->all());
        DB::beginTransaction();
        try {
            $storeBorrower = Borrower::where('id',decrypt($id))->update([ 
                'gender' =>  $request->borrower_gender, 
                'borrower_address' =>  $request->borrower_address, 
                'borrower_phone' =>  trim($request->borrower_phone), 
                'borrower_occupation' =>  $request->borrower_occupation, 
                'borrower_source_income' =>  $request->borrower_source_income, 
                'borrower_income' =>  $request->borrower_income,
                'borrower_id_card_no' =>  $request->borrower_id_card_no,
                'is_active' => '0'
            ]);

            if ($request->hasFile('borrower_id_card')) {
                //dd('hai');
                $path_loc = $request->file('borrower_id_card');
                $filename = $path_loc->getClientOriginalName();
                $extension = $path_loc->getClientOriginalExtension();
                $url = $path_loc->move('storage/id_card/borrower/', $filename);
                //dd($path_loc,$filename,$extension,$url);

                Borrower::where('id',decrypt($id))->update([
                    'borrower_id_card' =>  $url->getPath()."/".$filename
                ]);
            }


            DB::commit();
            session()->flash('status', 'Sukses Update Data Peminjam, Silahkan Tunggu Moderasi Admin');
            return redirect('/');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Update Data Peminjam');
            return redirect('/');
        }
    }

    public function updateBank(Request $request, $id)
    {
        //dd(decrypt($id));
        
        //dd($request->all());
        DB::beginTransaction();
        try {
            $storeBorrower = Borrower::where('id',decrypt($id))->update([ 
                'borrower_bank_name' =>  $request->borrower_bank_name,
                'borrower_accountno' =>  $request->borrower_accountno,
                'borrower_accountname' =>  $request->borrower_accountname,
                'is_active' => '0'
            ]);

            DB::commit();
            session()->flash('status', 'Sukses Update Data Bank Peminjam, Silahkan Tunggu Moderasi Admin');
            return redirect('/');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Update Data Bank Peminjam');
            return redirect('/');
        }
    }

    public function approvedLoan($id){
        DB::beginTransaction();
        try {
            Loan::where('id',decrypt($id))->update([
                'status' => 'approved'
            ]);

            DB::commit();
            session()->flash('status', 'Sukses Approved Pinjaman');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Approved Pinjaman');
            return redirect()->back();
        }       
    }

    public function rejectedLoan($id){
        DB::beginTransaction();
        try {
            Loan::where('id',decrypt($id))->update([
                'status' => 'rejected'
            ]);

            DB::commit();
            session()->flash('status', 'Sukses Rejected Pinjaman');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Rejected Pinjaman');
            return redirect()->back();
        }       
    }
}
