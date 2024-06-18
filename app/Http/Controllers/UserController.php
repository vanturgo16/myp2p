<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class UserController extends Controller
{
    public function indexInternal(){
        $datas = User::where('role','<>','Investor')
        ->where('role','<>','Borrower')
        ->orderBy('name', 'asc')->get();

        return view('users.indexInternal',compact('datas'));
    }

    public function indexBorrower(){
        $datas = User::where('role','Borrower')
        ->orderBy('name', 'asc')->get();

        return view('users.indexBorrower',compact('datas'));
    }

    public function showBorrower($id){
        $borrower = Borrower::where('user_id',decrypt($id))->first();

            if($borrower->is_active == '0' && $borrower->borrower_accountno == ''){
                $progress = "Data Lengkap";
            }
            elseif($borrower->is_active == '0' && $borrower->borrower_accountno != ''){
                $progress = "Proses KYC";
            }
            elseif($borrower->is_active == '1'){
                $progress = "Siap Pengajuan";
            }
            else{
                $progress = "";
            }

        return view('users.showBorrower',compact('borrower','progress'));
    }
    
    public function eligibleBorrower($id){
        DB::beginTransaction();
        try {
            $store = Borrower::where('id',decrypt($id))
            ->update([
                'is_active' => '1',
                'loan_limit' => '10000000' //di hardcode dulu belum ada logic
            ]);

            DB::commit();
            return redirect()->back()->with(['success' => 'Success Update Status']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with(['fail' => 'Failed Update Status']);
        }
    }

    public function store(Request $request){
        //dd($request->all());
        $request->validate([
            "user_name" => "required",
            "user_email" => "required",
            "user_password" => "required",
            "user_role" => "required"
        ]);

        //dd('hai');
        DB::beginTransaction();
        try {
            //$user = auth()->user()->email;
            $store = User::create([
                'name' => $request->user_name,
                'email' => $request->user_email,
                'password' => $request->user_password,
                'role' => $request->user_role
            ]);

            DB::commit();
            return redirect()->back()->with(['success' => 'Success Add Data']);
        } catch (\Throwable $th) {
            // dd($th);
            DB::rollback();
            return redirect()->back()->with(['fail' => 'Failed Add Data']);
        }
    }

    public function update(Request $request,$id){
        $request->validate([
            "user_name" => "required",
            "user_email" => "required",
            "user_role" => "required"
        ]);

        //dd('hai');
        DB::beginTransaction();
        try {
            //$user = auth()->user()->email;
            $store = User::where('id',$id)
            ->update([
                'name' => $request->user_name,
                'email' => $request->user_email,
                'role' => $request->user_role
            ]);

            DB::commit();
            return redirect()->back()->with(['success' => 'Success Update Data']);
        } catch (\Throwable $th) {
            // dd($th);
            DB::rollback();
            return redirect()->back()->with(['fail' => 'Failed Update Data']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $store = User::where('id',decrypt($id))
            ->update([
                'is_active' => 0,
            ]);

            DB::commit();
            return redirect()->back()->with(['success' => 'Success Delete Data']);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return redirect()->back()->with(['fail' => 'Failed Delete Data']);
        }
    }

    public function active($id){
        DB::beginTransaction();
        try {
            $store = User::where('id',decrypt($id))
            ->update([
                'is_active' => '1'
            ]);

            DB::commit();
            return redirect()->back()->with(['success' => 'Success Activate Data']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with(['fail' => 'Failed Delete Data']);
        }
    }
}
