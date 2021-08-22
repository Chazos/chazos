<?php

namespace App\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TestController extends Controller
{
    //

    public function test_database(Request $request){

        $data = [
            "table_name" => "blog",
            "columns" => [
                [
                    'field_name' => 'name',
                    'field_type' => 'string',
                ],
                [
                    'field_name' => 'color',
                    'field_type' => 'string',
                ],
                [
                    'field_name' => 'age',
                    'field_type' => 'integer',
                ],

            ]
        ];

        $table_name = $data['table_name'];
        $columns = $data['columns'];

        $table_string = "Schema::create('$table_name', function (\$table) {";

        foreach ($columns as $column){
            $field_name = $column['field_name'];
            $field_type = $column['field_type'];

            $table_string .= "\$table->$field_type('$field_name');";


        }

        $table_string .= "});";
        eval($table_string);





    }
}
