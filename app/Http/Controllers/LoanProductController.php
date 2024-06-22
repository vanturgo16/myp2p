<?php

namespace App\Http\Controllers;

use App\Models\LoanProduct;
use Illuminate\Http\Request;

class LoanProductController extends Controller
{
    public function getProduct($id){
        $loanProduct = LoanProduct::find($id);
        if ($loanProduct) {
            return response()->json($loanProduct);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }
}
