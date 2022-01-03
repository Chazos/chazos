<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Import Events
use App\Events\DashDataCreated;
use App\Events\DashDataUpdated;
use App\Events\DashDataDeleted;

class TableDataController extends Controller
{
    public function manage(Request $request, $id)
    {
        $table = Table::where('id', $id)->first();
        $config_fields = json_decode(json_encode(json_decode($table->configure_fields)), true);
        $columns = json_decode($table->fields);
        $actions = json_decode($table->actions) ?: [];


        $model = "App\Models\\" . $table->model_name;


        $data = $model::simplePaginate(10);
        return view('admin.table_data.manage', compact('table', 'config_fields', 'table', 'columns', 'actions', 'data'));
    }


    public function import_data(Request $request, $table_name){

        $table = Table::where('table_name', $table_name)->first();
        $model_name = $table->model_name;
        $columns = Schema::getColumnListing($table_name);
        $model = "App\Models\\" . $table->model_name;




        $import_model = "App\\Imports\\" . $model_name . "Import";
        $array = \Excel::toArray(new $import_model, $request->import_file);

        foreach($array[0] as $row){
            $new_entry_array = [];
            foreach($row as $key => $value){
                $current_field = $columns[$key];

                try{
                    $new_entry_array[$current_field] = $value;
                }catch (\Exception $e){
                    $new_entry_array[$current_field] = "";
                }

            }

            $model::create($new_entry_array);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Records have been imported sucessfully.'
        ]);





    }

    public function export_data(Request $request, $table_name)
    {

        $table = Table::where('table_name', $table_name)->first();
        $model_name = $table->model_name;


        $export_model = "App\\Exports\\" . $model_name . "Export";

        return \Excel::download(new $export_model, "$table_name.csv");
    }

    public function delete_item(Request $request, $table_name, $id)
    {

        try {
            $table = Table::where('table_name', $table_name)->first();
            $model = "App\\Models\\" . $table->model_name;
            $item = $model::where('id', $id)->first();

            try{
                $item->media()->delete();
            }catch (\Exception $e){

            }finally{
                DashDataDeleted::dispatch($table_name, $item);
                $item->delete();
            }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Record has been deleted successfully.'
        ]);
    }

    public function add_entry(Request $request, $table_name)
    {
        $table = Table::where('table_name', $table_name)->first();
        $columns = json_decode($table->fields);
        return view('admin.table_data.add_entry', compact('table', 'table', 'columns'));
    }

    public function edit_item(Request $request, $table, $id)
    {
        $table =  Table::where('table_name', $table)->first();
        $model = "App\Models\\" . $table->model_name;
        $item = $model::where('id', $id)->first();
        $fields = json_decode($table->fields);
        return view('admin.table_data.edit', compact('table', 'item', 'table', 'fields'));
    }



    public function create_entry(Request $request, $table_name)
    {

        $table = Table::where('table_name', $table_name)->first();



        $fields = json_decode($table->fields);
        $model_name = $table->model_name;
        $model = "App\Models\\" . $model_name;
        $new_entry = new $model;

        foreach ($fields as $field) {
            $field_name = $field->field_name;
            $field_type = $field->field_type;


            if (array_key_exists($field_name, $request->all())) {
                $add_field_data = $new_entry->$field_name = $request->$field_name;
            }
        }



        $new_entry->save();

        // Attach files
        foreach ($fields as $field) {
            $field_name = $field->field_name;
            $field_type = $field->field_type;
            $accepts_file = $field->accepts_file;
            $file_type = $field->file_type;



            if ($accepts_file == "true") {
                if (array_key_exists($field_name, $request->all())) {
                    if ($file_type == "image") {

                        if ($request->hasFile($field->field_name) && $request->file($field->field_name)->isValid()) {

                            $new_entry->addMediaFromRequest($field->field_name)
                                ->toMediaCollection($field->field_name);

                            $image_url = $new_entry->getFirstMedia($field->field_name)->getUrl();
                            $add_field_data = $new_entry->$field_name = $image_url;
                            $new_entry->save();
                        }
                    }
                }
            }
        }

        DashDataCreated::dispatch($table_name, $new_entry);

        return response()->json([
            'status' => 'success',
            'message' => 'Entry created successfully'
        ]);
    }

    public function update_item(Request $request, $table_name, $id)
    {

        $table = Table::where('table_name', $table_name)->first();
        $fields = json_decode($table->fields);
        $model_name = $table->model_name;
        $model = "App\Models\\" . $model_name;
        $current_entry = $model::where('id', $id)->first();



        foreach ($fields as $field) {
            $field_name = $field->field_name;
            $field_type = $field->field_type;


            if (array_key_exists($field_name, $request->all()) && $field->accepts_file == "false") {

                // $add_field_data = "\$current_entry->$field_name = \$request->$field_name;";
                $add_field_data = $current_entry->$field_name = $request->$field_name;
                // eval($add_field_data);
            }
        }





        // Attach files
        foreach ($fields as $field) {
            $field_name = $field->field_name;
            $field_type = $field->field_type;
            $accepts_file = $field->accepts_file;
            $file_type = $field->file_type;




            if ($accepts_file == "true") {

                if (array_key_exists($field_name, $request->all())) {

                    if ($file_type == "image") {

                        if ($request->hasFile($field->field_name) && $request->file($field->field_name)->isValid()) {

                            $current_entry->media()->delete();
                            $current_entry->addMediaFromRequest($field->field_name)
                                ->toMediaCollection($field->field_name);

                            $image_url = $current_entry->getFirstMedia($field->field_name)->getUrl();
                            $add_field_data = "\$current_entry->$field_name = \$image_url;";
                            eval($add_field_data);
                            $current_entry->save();
                        }
                    }
                }
            }
        }

        $current_entry->save();
        DashDataUpdated::dispatch($table_name, $current_entry);

        return response()->json([
            'status' => 'success',
            'message' => 'Entry edited successfully'
        ]);
    }
}
