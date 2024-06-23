<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Lender;
use App\Models\Loan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        if(auth()->check() && auth()->user()->role == 'Borrower'){
            $id = auth()->user()->id;

            $borrowerStatus = Borrower::where('user_id',$id)->first();

            $loanActiveCount = Loan::where('borrower_id',$borrowerStatus->id)->count();
            $loanPaidCount = Loan::where('borrower_id',$borrowerStatus->id)->where('status','paid')->orderBy('id','desc')->limit('1')->count();
            //dd($loanActiveCount,$loanPaidCount);
            if($borrowerStatus->is_active == '0' && $borrowerStatus->borrower_accountno == ''){
                $progress = "<ul class='steps steps-green steps-counter my-4'>
                            <li class='step-item active'>Lengkapi Data Bank</li> 
                            <li class='step-item'>Proses KYC</li>
                            <li class='step-item'>Siap Pengajuan</li>
                            </ul>";
            }
            elseif($borrowerStatus->is_active == '0' && $borrowerStatus->borrower_accountno != ''){
                $progress = "<ul class='steps steps-green steps-counter my-4'>
                            <li class='step-item'>Lengkapi Data Bank</li> 
                            <li class='step-item active'>Proses KYC</li>
                            <li class='step-item'>Siap Pengajuan</li>
                            </ul>";
            }
            elseif($borrowerStatus->is_active == '1'){
                $progress = "<ul class='steps steps-green steps-counter my-4'>
                            <li class='step-item'>Lengkapi Data Bank</li> 
                            <li class='step-item'>Proses KYC</li>
                            <li class='step-item active'>Siap Pengajuan</li>
                            </ul>";
            }
            else{
                $progress = '
                <div class="alert alert-important alert-info alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                    </div>
                    <div>
                    Anda belum berhak mengajukan pinjaman, mohon ulangi permohonan anda dalam beberapa waktu
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
                ';
            }

            return view('welcome',compact('progress','borrowerStatus','loanPaidCount','loanActiveCount'));
        }
        elseif(auth()->check() && auth()->user()->role == 'Lender'){
            $id = auth()->user()->id;

            $lenderStatus = Lender::where('user_id',$id)->first();
            if($lenderStatus->is_active == '0' && $lenderStatus->lender_accountno == ''){
                $progress = "<ul class='steps steps-green steps-counter my-4'>
                            <li class='step-item active'>Lengkapi Data Bank</li> 
                            <li class='step-item'>Proses KYC</li>
                            <li class='step-item'>Siap Mendanai Pinjaman</li>
                            </ul>";
            }
            elseif($lenderStatus->is_active == '0' && $lenderStatus->lender_accountno != ''){
                $progress = "<ul class='steps steps-green steps-counter my-4'>
                            <li class='step-item'>Lengkapi Data Bank</li> 
                            <li class='step-item active'>Proses KYC</li>
                            <li class='step-item'>Siap Mendanai Pinjaman</li>
                            </ul>";
            }
            elseif($lenderStatus->is_active == '1'){
                $progress = "<ul class='steps steps-green steps-counter my-4'>
                            <li class='step-item'>Lengkapi Data Bank</li> 
                            <li class='step-item'>Proses KYC</li>
                            <li class='step-item active'>Siap Mendanai Pinjaman</li>
                            </ul>";
            }
            else{
                $progress = '
                <div class="alert alert-important alert-info alert-dismissible" role="alert">
                <div class="d-flex">
                    <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                    </div>
                    <div>
                    Anda belum berhak mengajukan pinjaman, mohon ulangi permohonan anda dalam beberapa waktu
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
                ';
            }

            return view('welcome',compact('progress','lenderStatus'));
        }
        else{
            $progress = "";
            $borrowerStatus = "";
            $loanActiveCount = "";
            $loanPaidCount = "";
            return view('welcome',compact('progress','borrowerStatus','loanPaidCount','loanActiveCount'));
        }
    }
}
