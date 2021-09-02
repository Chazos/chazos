<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CollectionsController extends Controller
{
    public function manage(Request $request, $table){
        $collection = ContentType::where('collection_name', $table)->first();
        $config_fields = json_decode(json_encode(json_decode($collection->configure_fields)), true);
        $columns = json_decode($collection->fields);
        $model = "App\Models\\" . $collection->model_name;


        $data = $model::all();
        return view('admin.collections.manage', compact('table','config_fields', 'collection', 'columns', 'data'));
    }

    public function delete_item(Request $request, $table_name, $id){

        $collection = ContentType::where('collection_name', $table_name)->first();
        $model = "App\Models\\" . $collection->model_name;
        $item = $model::where('id', $id)->first();

        $item->media()->delete();
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Record has been deleted successfully.']);
    }

    public function add_entry(Request $request, $table){
        $collection = ContentType::where('collection_name', $table)->first();
        $columns = json_decode($collection->fields);
        return view('admin.collections.add_entry', compact('table', 'collection', 'columns'));

    }

    public function edit_item(Request $request, $table, $id){
        $collection =  ContentType::where('collection_name', $table)->first();
        $model = "App\Models\\" . $collection->model_name;
        $item = $model::where('id', $id)->first();
        $fields = json_decode($collection->fields);
        return view('admin.collections.edit', compact('table','item', 'collection', 'fields'));
    }



    public function create_entry(Request $request, $table_name){

        $collection = ContentType::where('collection_name', $table_name)->first();


        $fields = json_decode($collection->fields);
        $model_name = $collection->model_name;
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

        $collection = ContentType::where('collection_name', $table_name)->first();
        $fields = json_decode($collection->fields);
        $model_name = $collection->model_name;
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
