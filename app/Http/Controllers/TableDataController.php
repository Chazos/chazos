<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TableDataController extends Controller
{
    public function manage(Request $request, $table){
        $table = Table::where('table_name', $table)->first();
        $config_fields = json_decode(json_encode(json_decode($table->configure_fields)), true);
        $columns = json_decode($table->fields);
        $model = "App\Models\\" . $table->model_name;


        $data = $model::all();
        return view('admin.table_data.manage', compact('table','config_fields', 'table', 'columns', 'data'));
    }

    public function delete_item(Request $request, $table_name, $id){

        $table = Table::where('table_name', $table_name)->first();
        $model = "App\Models\\" . $table->model_name;
        $item = $model::where('id', $id)->first();

        $item->media()->delete();
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Record has been deleted successfully.']);
    }

    public function add_entry(Request $request, $table_name){
        $table = Table::where('table_name', $table_name)->first();
        $columns = json_decode($table->fields);
        return view('admin.table_data.add_entry', compact('table', 'table', 'columns'));

    }

    public function edit_item(Request $request, $table, $id){
        $table =  Table::where('table_name', $table)->first();
        $model = "App\Models\\" . $table->model_name;
        $item = $model::where('id', $id)->first();
        $fields = json_decode($table->fields);
        return view('admin.table_data.edit', compact('table','item', 'table', 'fields'));
    }



    public function create_entry(Request $request, $table_name){

        $table = Table::where('table_name', $table_name)->first();

    

        $fields = json_decode($table->fields);
        $model_name = $table->model_name;
        $model = "App\Models\\". $model_name;
        $new_entry = new $model;

        foreach($fields as $field){
            $field_name = $field->field_name;
            $field_type = $field->field_type;


            if (array_key_exists($field_name, $request->all())){

                $add_field_data = "\$new_entry->$field_name = \$request->$field_name;";
                eval($add_field_data);
            }

        }



        $new_entry->save();

        // Attach files
        foreach($fields as $field){
            $field_name = $field->field_name;
            $field_type = $field->field_type;
            $accepts_file = $field->accepts_file;
            $file_type = $field->file_type;



            if($accepts_file == "true"){
                if (array_key_exists($field_name, $request->all())){
                    if ($file_type == "image"){

                        if($request->hasFile( $field->field_name) && $request->file($field->field_name)->isValid()){

                            $new_entry->addMediaFromRequest( $field->field_name)->toMediaCollection($field->field_name);
                        }
                    }
                }
            }

        }

        return response()->json([
            'status' => 'success',
            'message' => 'Entry created successfully'
        ]);
    }

    public function update_item(Request $request, $table_name, $id){

        $table = Table::where('table_name', $table_name)->first();
        $fields = json_decode($table->fields);
        $model_name = $table->model_name;
        $model = "App\Models\\". $model_name;
        $current_entry = $model::where('id', $id)->first();



        foreach($fields as $field){
            $field_name = $field->field_name;
            $field_type = $field->field_type;


            if (array_key_exists($field_name, $request->all()) && $field->accepts_file == "false"){

                $add_field_data = "\$current_entry->$field_name = \$request->$field_name;";
                eval($add_field_data);
            }

        }





        // Attach files
        foreach($fields as $field){
            $field_name = $field->field_name;
            $field_type = $field->field_type;
            $accepts_file = $field->accepts_file;
            $file_type = $field->file_type;




            if($accepts_file == "true"){

                if (array_key_exists($field_name, $request->all())){

                    if ($file_type == "image"){

                        if($request->hasFile( $field->field_name) && $request->file($field->field_name)->isValid()){

                            $current_entry->media()->delete();
                            $current_entry->addMediaFromRequest( $field->field_name)->toMediaCollection($field->field_name);
                        }
                    }
                }
            }

        }

        $current_entry->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Entry edited successfully'
        ]);
    }

}
