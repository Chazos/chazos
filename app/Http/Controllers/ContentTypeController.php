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

    public function addColumn($table_name, $field, $action = "create"){
        $field_name = $field['field_name'];
        $field_type = $field['field_type'];
        $unique = $field['unique'];
        $default = $field['default'];
        $nullable = $field['nullable'];


        $table_string = "if (Schema::hasColumn('$table_name', '$field_name') == false){";

        $table_string .= "Schema::$action('$table_name', function (\$table) {";
        $table_string .= "\$table->$field_type('$field_name')";

        if ($unique == "true"){
            $table_string .= "->unique()";
        }

        if ($default != "" && $default != "null" || $default != null){
            $table_string .= "->default('$default')";
        }

        if ($nullable == "true"){
            $table_string .= "->nullable()";
        }

        $table_string .= ";";
        $table_string .= "});";
        $table_string .= "}";
        eval($table_string);

    }

    public function create(Request $request){

        $fields = $request->fields;
        $configure_fields = $request->configure_fields;
        $table_name = $request->name;
        $display_name = $request->display_name;



        foreach ($fields as $field){
            $this->addColumn($table_name, $field);
        }

        // Save collection details to the

        $new_content_type = new ContentType();

        $new_content_type->display_name = $display_name;
        $new_content_type->collection_name = $table_name;
        $new_content_type->slug = $table_name;
        $new_content_type->fields = json_encode($fields);
        $new_content_type->configure_fields = json_encode($configure_fields);
        $new_content_type->save();

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
                $this->deleteColumn($table_name, $field);
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
            $this->addColumn($table_name, $field, 'table');
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


    public function renameColumn($table_name, $old_name, $new_name){
        $table_string = "Schema::table('$table_name', function (\$table)";
        $table_string .= "{\$table->renameColumn('$old_name', '$new_name');});";

        eval($table_string);

    }

    public function deleteColumn($table_name ){
        $table_string = "Schema::table('$table_name', function (\$table) {";
        $table_string .= "\$table->dropColumn('$column');";
        $table_string .= "});";

        eval($table_string);
    }

    public function dropForeign($table_name, $column_name){
        $foreign_column_name = $table_name . '_';
        $foreign_column_name .= $column_name . '_foreign';
        $table_string = "Schema::table('$table_name', function(\$table)";
        $table_string .= "{\$table->dropForeign('$foreign_column_name');});";

        eval($table_string);
    }

    public function addForeignKey($table_name, $column_name, $foreign_table, $foreign_column_name, $on_delete=""){
        $table_string = "Schema::table('$table_name', function(\$table){";
        $table_string .= "\$table->foreign('$column_name')";
        $table_string .= "->references('$foreign_column_name')";


        if ($on_delete == ""){
            $table_string .= "->on('$foreign_table');";
        }else{
            $table_string .= "->on('$foreign_table')";
            $table_string .= "->onDelete('$on_delete')";
        }

        $table_string .= "});";
        eval($table_string);

    }
}
