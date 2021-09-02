<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TableController extends Controller
{
    //

    public function index(){
        $tables = Table::all();
        return view('admin.tables.index', ['tables' => $tables]);
    }

    public function fields(Request $request, $table){
        $table = Table::where('table_name', $table)->first();
        $fields = json_decode($table->fields);

        return response()->json([
            'status' => 'success',
            'fields' => $fields
        ]);

    }

    public function delete($id){

        $table = Table::where('id', $id)->first();
        $table_name = $table->table_name;
        eval("Schema::dropIfExists('$table_name');");
        delete_model($table_name);
        $table->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Table Deleted Successfully'
        ]);
    }

    public function details(Request $request, $id){
        $table = Table::where("id", $id)->first();
        $status = "failed";

        if ($table != null){
            $status = "success";
        }

        return response()->json([
            'status' => $status,
            'data' => $table
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

        // Save table details to the

        $new_table = new Table();

        $new_table->display_name = $display_name;
        $new_table->model_name = $model_name;
        $new_table->table_name = $table_name;
        $new_table->slug = $table_name;
        $new_table->fields = json_encode($fields);
        $new_table->configure_fields = json_encode($configure_fields);
        $new_table->save();


        // Create model for table
        $table_accepts_media = cg_supports_media($fields);


        create_model($model_name, $table_name, $table_accepts_media);



        return response()->json([
            'status' => 'success',
            'message' => 'Table Created',
            'details' => $request]);



    }

    public function update(Request $request, $id){

        $table_id = $id;
        $table_name = $request->table_name;
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
        $update_collection = Table::where('id', $id)->first();

        if ($update_collection != null){
            $update_collection->display_name = $display_name;
            $update_collection->table_name = $table_name;
            $update_collection->slug = $table_name;
            $update_collection->fields = json_encode($fields);
            $update_collection->configure_fields = json_encode($configure_fields);
            $update_collection->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Table Updated',
                'details' => $request]);
        }





    }



}



