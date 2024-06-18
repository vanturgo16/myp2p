<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        if(auth()->check() && auth()->user()->role == 'Borrower'){
            $id = auth()->user()->id;

            $borrowerStatus = Borrower::where('user_id',$id)->first();

            if($borrowerStatus->is_active == '0' && $borrowerStatus->borrower_accountno == ''){
                $progress = "<li class='step-item active'>Data Lengkap</li> 
                                <li class='step-item'>Proses KYC</li>
                                <li class='step-item'>Siap Pengajuan</li>";
            }
            elseif($borrowerStatus->is_active == '0' && $borrowerStatus->borrower_accountno != ''){
                $progress = "<li class='step-item'>Data Lengkap</li> 
                                <li class='step-item active'>Proses KYC</li>
                                <li class='step-item'>Siap Pengajuan</li>";
            }
            elseif($borrowerStatus->is_active == '1'){
                $progress = "<li class='step-item'>Data Lengkap</li> 
                                <li class='step-item'>Proses KYC</li>
                                <li class='step-item active'>Siap Pengajuan</li>";
            }
            else{
                $progress = "<li class='step-item'>Data Lengkap</li> 
                                <li class='step-item'>Proses KYC</li>
                                <li class='step-item'>Siap Pengajuan</li>";
            }

            return view('welcome',compact('progress'));
        }
        else{
            $progress = "";
            return view('welcome',compact('progress'));
        }
    }
}
