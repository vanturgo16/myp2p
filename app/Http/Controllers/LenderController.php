<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LenderController extends Controller
{
    public function indexRegist()
    {
        return view('lenders.registration');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try {

            $storeUser = User::create([
                'name' => $request->lender_name,
                'email' => $request->lender_email,
                'password' => $request->lender_password,
                'role' => 'Lender'
            ]);

            if ($request->hasFile('lender_id_card')) {
                //dd('hai');
                $path_loc = $request->file('lender_id_card');
                $filename = $path_loc->getClientOriginalName();
                $extension = $path_loc->getClientOriginalExtension();
                $url = $path_loc->move('storage/id_card/lender/', $filename);
                //dd($path_loc,$filename,$extension,$url);
            }

            $storelender = Lender::create([
                'user_id'=> $storeUser->id, 
                'lender_name' => $request->lender_name, 
                'gender' =>  $request->lender_gender, 
                'lender_address' =>  $request->lender_address, 
                'lender_phone' =>  trim($request->lender_phone), 
                'lender_occupation' =>  $request->lender_occupation, 
                'lender_source_income' =>  $request->lender_source_income, 
                'lender_income' =>  $request->lender_income, 
                'lender_id_card_no' =>  $request->lender_id_card_no,
                'lender_id_card' =>  $url->getPath()."/".$filename,
                'is_active' => '0'
            ]);

            DB::commit();
            session()->flash('status', 'Sukses Registrasi Pemodal, Silahkan Login');
            return redirect('/');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Registrasi Pemodal');
            return redirect('/');
        }
    }

    public function viewProfile($id){
        $lender = Lender::where('user_id',decrypt($id))->first();
        return view('lenders.profile',compact('lender'));
    }

    public function update(Request $request, $id)
    {
        //dd(decrypt($id));
        
        //dd($request->all());
        DB::beginTransaction();
        try {
            $storelender = Lender::where('id',decrypt($id))->update([ 
                'gender' =>  $request->lender_gender, 
                'lender_address' =>  $request->lender_address, 
                'lender_phone' =>  trim($request->lender_phone), 
                'lender_occupation' =>  $request->lender_occupation, 
                'lender_source_income' =>  $request->lender_source_income, 
                'lender_income' =>  $request->lender_income,
                'lender_id_card_no' =>  $request->lender_id_card_no,
                'is_active' => '0'
            ]);

            if ($request->hasFile('lender_id_card')) {
                //dd('hai');
                $path_loc = $request->file('lender_id_card');
                $filename = $path_loc->getClientOriginalName();
                $extension = $path_loc->getClientOriginalExtension();
                $url = $path_loc->move('storage/id_card/lender/', $filename);
                //dd($path_loc,$filename,$extension,$url);

                lender::where('id',decrypt($id))->update([
                    'lender_id_card' =>  $url->getPath()."/".$filename
                ]);
            }


            DB::commit();
            session()->flash('status', 'Sukses Update Data Pemodal, Silahkan Tunggu Moderasi Admin');
            return redirect('/');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Update Data Pemodal');
            return redirect('/');
        }
    }

    public function updateBank(Request $request, $id)
    {
        //dd(decrypt($id));
        
        //dd($request->all());
        DB::beginTransaction();
        try {
            $storelender = lender::where('id',decrypt($id))->update([ 
                'lender_bank_name' =>  $request->lender_bank_name,
                'lender_accountno' =>  $request->lender_accountno,
                'lender_accountname' =>  $request->lender_accountname,
                'is_active' => '0'
            ]);

            DB::commit();
            session()->flash('status', 'Sukses Update Data Bank Pemodal, Silahkan Tunggu Moderasi Admin');
            return redirect('/');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            session()->flash('status', 'Gagal Update Data Bank Pemodal');
            return redirect('/');
        }
    }
}
