<?php

use App\Models\Table;
use Illuminate\Support\Facades\Schema;

if (! function_exists('ct_add_column')) {
    function ct_add_column($table_name, $field, $action = "create")
    {
        $field_name = $field['field_name'];
        $field_type = $field['field_type'];
        $unique = $field['unique'];
        $default = $field['default'];
        $nullable = $field['nullable'];

        $table_string = "if (Schema::hasColumn('$table_name', '$field_name') == false){";

        $table_string .= "Schema::$action('$table_name', function (\$table) {";
        $table_string .= "\$table->$field_type('$field_name')";

        if ($unique == "true") {
            $table_string .= "->unique()";
        }

        if ($default != "" && $default != "null" || $default != null) {
            $table_string .= "->default('$default')";
        }

        if ($nullable == "true") {
            $table_string .= "->nullable()";
        }

        $table_string .= ";";
        $table_string .= "});";
        $table_string .= "}";
        eval($table_string);
    }
}

if (! function_exists('ct_add_id_field')) {
    function ct_add_id_field($table_name)
    {

        $table_string = "Schema::create('$table_name', function (\$table) {";
        $table_string .= "\$table->id();";
        $table_string .= "});";
        eval($table_string);
    }
}

if (! function_exists('ct_add_timestamps')) {
    function ct_add_timestamps($table_name)
    {

        $table_string = "Schema::table('$table_name', function (\$table) {";
        $table_string .= "\$table->timestamps();";
        $table_string .= "});";
        eval($table_string);
    }
}

if (! function_exists('ct_rename_column')) {
    function ct_rename_column($table_name, $old_name, $new_name){
        $table_string = "Schema::table('$table_name', function (\$table)";
        $table_string .= "{\$table->renameColumn('$old_name', '$new_name');});";

        eval($table_string);

    }
}

if (! function_exists('ct_delete_column')) {
    function ct_delete_column($table_name, $field ){
        $field_name = $field['field_name'];

        $table_string = "Schema::table('$table_name', function (\$table) {";
        $table_string .= "\$table->dropColumn('$field_name');";
        $table_string .= "});";

        eval($table_string);
    }
}

if (! function_exists('ct_drop_foreign')) {
    function ct_drop_foreign($table_name, $column_name){
        $foreign_column_name = $table_name . '_';
        $foreign_column_name .= $column_name . '_foreign';
        $table_string = "Schema::table('$table_name', function(\$table)";
        $table_string .= "{\$table->dropForeign('$foreign_column_name');});";

        eval($table_string);
    }
}

if (! function_exists('ct_add_foreign_key')) {
        function ct_add_foreign_key($table_name, $column_name, $foreign_table, $foreign_column_name, $on_delete=""){
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
