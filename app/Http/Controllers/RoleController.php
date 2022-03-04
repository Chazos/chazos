<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    //

    public function roles(Request $request){

        $roles = Role::all();
        return view('admin.settings.auth.roles', compact('roles'));
    }

    public function user_roles(Request $request){
        $roles = Role::all();
        return view('admin.settings.auth.user_roles', compact('roles'));
    }

    public function assign_role(Request $request){
        $user = User::where('id', $request->user_id)->first();
        $user->assignRole($request->role_name);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Role Assigned Successfully',
            'user' => $user]);


    }

    public function create_role(Request $request){

        try{
        $role = Role::create([
            'name' => $request->role_name,
            'guard_name' => $request->guard_name]);

        }catch(RoleAlreadyExists $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Role Already Exists'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Role Created Successfully',
            'role' => $role]);
    }
}
