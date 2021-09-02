<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class DataController extends Controller
{
    //

    public function index(Request $request, $table_name){
        $table = Table::where('table_name', $table_name)->first();


        if ($table != null){
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
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data not found'
        ]);
    }

    public function show(Request $request, $table_name, $id){
        $table = Table::where('table_name', $table_name)->first();



        if ($table != null){
            $model = "App\Models\\". $table->model_name;
            $resource_name = "App\Http\Resources\\" . ucfirst($table_name) . 'Resource';
            $model = 'App\Models\\' . $table->model_name;
            $data = $model::where('id', $id)->first();


            return response()->json([
                'status' => 'success',
                'data' => new $resource_name($data),
                'message' => 'Data retrieved successfully'
        ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data not found'
        ]);
    }

    public function delete(Request $request, $table_name, $id){
        $table = Table::where('table_name', $table_name)->first();



        if ($table != null){
            $model = "App\Models\\". $table->model_name;
            $model = 'App\Models\\' . $table->model_name;
            $data = $model::where('id', $id)->first();


            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully'
        ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Data not found'
        ]);


    }
}
