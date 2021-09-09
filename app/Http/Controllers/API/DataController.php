<?php

namespace App\Http\Controllers\API;

use App\Events\ContactSaved;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DataController extends Controller
{
    //

    public function user_can_perform_action($table_name, $action){


        $whole_perm = "can " . $action . " " . $table_name;
        $user = User::where('id', Auth::id())->first();
        $status = false;


        if ($user == null){
            $role =  Role::where('name','everyone')->first();
            $status = $role->hasPermissionTo($whole_perm);
        }else{

            $role_names = $user->getRoleNames();

            foreach ($role_names as $role_name){
                $role = Role::where('name', $role_name)->first();

                if ($role->hasPermissionTo($whole_perm)){
                    $status = true;
                    break;
                }


            }
        }




        return $status;
    }

    public function contact(Request $request){
        $data = $request->all();


        try{
            $contact = Contact::create($data);
            ContactSaved::dispatch($contact);
            return response()->json(['status' => 'success', 'message' => 'Message sent successfully!']);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


    public function index(Request $request, $table_name){
        $table = Table::where('table_name', $table_name)->first();

        if ($table != null){
            if ($this->user_can_perform_action($table_name, 'read')){
                $resource_name = "App\Http\Resources\\" . ucfirst($table_name) . 'Resource';
                $model = 'App\Models\\' . $table->model_name;
                $data = [];

                foreach($model::all() as $item){
                    $data[] = new $resource_name($item);
                }


                return response()->json([
                    'status' => 'success',
                    'data' => $data,
                    'message' => 'Data retrived successfully'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to perform this action'], 403);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data not found'
        ]);
    }

    public function show(Request $request, $table_name, $id){
        $table = Table::where('table_name', $table_name)->first();

        if ($table != null){
            if ($this->user_can_perform_action($table_name, 'read')){
                $model = "App\Models\\". $table->model_name;
                $resource_name = "App\Http\Resources\\" . ucfirst($table_name) . 'Resource';
                $model = 'App\Models\\' . $table->model_name;
                $data = $model::where('id', $id)->first();


                return response()->json([
                    'status' => 'success',
                    'data' => new $resource_name($data),
                    'message' => 'Data retrieved successfully'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to perform this action'], 403);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data not found'
        ]);
    }

    public function delete(Request $request, $table_name, $id){



        $table = Table::where('table_name', $table_name)->first();



        if ($table != null){
            if ($this->user_can_perform_action($table_name, 'delete')){
                $model = "App\Models\\". $table->model_name;
                $model = 'App\Models\\' . $table->model_name;
                $data = $model::where('id', $id)->first();

                $data->delete();


                return response()->json([
                    'status' => 'success',
                    'message' => 'Data deleted successfully'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have permission to perform this action'], 403);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data not found'
        ]);


    }
}
