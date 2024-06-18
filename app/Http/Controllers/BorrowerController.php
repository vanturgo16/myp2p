<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class BorrowerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function indexRegist()
    {
        return view('borrowers.registration');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createLoan($id)
    {
        //dd('hai');
        $borrower = Borrower::where('user_id',decrypt($id))->first();
        return view('borrowers.create_loan',compact('borrower'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
                $url = $path_loc->move('storage/id_card/', $filename);
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
                $storeLoan = Loan::create([
                    'borrower_id' => $request->borrower_id,
                    'loan_amount' => $loan_amount,
                    'loan_purpose' => $request->loan_purpose,
                    'interest_rate' => '2',
                    'duration_months' => '1',
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
        dd(decrypt($id));
    }

    public function viewProfile($id){
        $borrower = Borrower::where('user_id',decrypt($id))->first();
        return view('borrowers.profile',compact('borrower'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrower $borrower)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrower $borrower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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
                'is_active' => '0'
            ]);

            if ($request->hasFile('borrower_id_card')) {
                //dd('hai');
                $path_loc = $request->file('borrower_id_card');
                $filename = $path_loc->getClientOriginalName();
                $extension = $path_loc->getClientOriginalExtension();
                $url = $path_loc->move('storage/id_card/', $filename);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrower $borrower)
    {
        //
    }
}
