<?php

namespace App\Http\Controllers;

use App\Models\Lender;
use App\Models\Loan;
use Illuminate\Http\Request;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
