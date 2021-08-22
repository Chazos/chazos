<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    //

    public function index(){
        return view('admin.index');
    }

    public function manage(Request $request, $table){
        $columns = Schema::getColumnListing($table);
        $data = User::all();

        return view('admin.manage', compact('table', 'columns', 'data'));
    }
}
