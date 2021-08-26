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

    public function create(Request $request){

        $columns = $request->columns;
        $config_fields = $request->config_fields;
        $table_name = $request->name;
        $display_name = $request->display_name;

        $table_string = "Schema::create('$table_name', function (\$table) {";

        foreach ($columns as $column){
            $field_name = $column['field_name'];
            $field_type = $column['field_type'];
            $unique = $column['unique'];
            $default = $column['default'];
            $nullable = $column['nullable'];

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
        }

        $table_string .= "});";

        // Create a table
        eval($table_string);


        // Save collection details to the

        $new_content_type = new ContentType();

        $new_content_type->display_name = $display_name;
        $new_content_type->collection_name = $table_name;
        $new_content_type->slug = $table_name;
        $new_content_type->fields = json_encode($columns);
        $new_content_type->configure_fields = json_encode($config_fields);
        $new_content_type->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Content Type Created',
            'details' => $request]);



    }
}
