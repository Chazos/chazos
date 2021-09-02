<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ContentTypeController extends Controller
{
    //

    public function index(){
        $collections = ContentType::all();
        return view('admin.content_types.index', ['collections' => $collections]);
    }

    public function fields(Request $request, $table){
        $collection = ContentType::where('collection_name', $table)->first();
        $fields = json_decode($collection->fields);

        return response()->json([
            'status' => 'success',
            'fields' => $fields
        ]);

    }

    public function delete($id){

        $collection = ContentType::where('id', $id)->first();
        $table_name = $collection->collection_name;
        eval("Schema::dropIfExists('$table_name');");
        delete_model($table_name);
        $collection->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Content Type Deleted Successfully'
        ]);
    }

    public function details(Request $request, $id){
        $collection = ContentType::where("id", $id)->first();
        $status = "failed";

        if ($collection != null){
            $status = "success";
        }

        return response()->json([
            'status' => $status,
            'data' => $collection
        ]);
    }



    public function create(Request $request){

        $fields = $request->fields;
        $configure_fields = $request->configure_fields;
        $table_name = $request->name;
        $display_name = $request->display_name;
        $model_name = ucfirst($table_name);

        ct_add_id_field($table_name);

        foreach ($fields as $field){

            $skipFields = array("id", "created_at", "updated_at");

            if (in_array($field['field_name'], $skipFields)){
                continue;
            }

            ct_add_column($table_name, $field, 'table');

        }

        ct_add_timestamps($table_name);

        // Save collection details to the

        $new_content_type = new ContentType();

        $new_content_type->display_name = $display_name;
        $new_content_type->model_name = $model_name;
        $new_content_type->collection_name = $table_name;
        $new_content_type->slug = $table_name;
        $new_content_type->fields = json_encode($fields);
        $new_content_type->configure_fields = json_encode($configure_fields);
        $new_content_type->save();


        // Create model for table
        $table_accepts_media = cg_supports_media($fields);


        create_model($model_name, $table_name, $table_accepts_media);



        return response()->json([
            'status' => 'success',
            'message' => 'Content Type Created',
            'details' => $request]);



    }

    public function update(Request $request, $id){

        $table_id = $id;
        $table_name = $request->collection_name;
        $fields = $request->fields;
        $configure_fields = $request->configure_fields;
        $display_name = $request->display_name;


        // Delete fields if any
        $delete_fields = $request->delete_fields;


        if ($delete_fields != null){
            foreach($delete_fields as $field){
                ct_delete_column($table_name, $field);
            }
        }

        // Rename fields if any
        // TODO implemenent

        // Drop foreing keys if any
        // TODO implement


        // Add foreign keys if any
        // TODO implement


        // Add new fields if any
        foreach ($fields as $field){
            ct_add_column($table_name, $field, 'table');
        }

        // Finally Save the data
        $update_collection = ContentType::where('id', $id)->first();

        if ($update_collection != null){
            $update_collection->display_name = $display_name;
            $update_collection->collection_name = $table_name;
            $update_collection->slug = $table_name;
            $update_collection->fields = json_encode($fields);
            $update_collection->configure_fields = json_encode($configure_fields);
            $update_collection->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Content Type Updated',
                'details' => $request]);
        }





    }



}



