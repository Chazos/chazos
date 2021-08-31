<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    //

    public function index(){
        // $model_name = 'App\Models\User';

        // dd($model_name::all());
        return view('admin.index');
    }
}
