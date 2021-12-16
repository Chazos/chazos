<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    //

    public function index(){
        $transactions = Transactions::all();
        return view('admin.transactions.index', compact('transactions'));
    }
}
