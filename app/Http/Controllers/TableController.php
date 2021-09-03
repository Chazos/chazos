<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

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
        cg_delete_model($table_name);
        cg_delete_resource($table_name);
        tb_delete_perms($table_name);
        $table->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Table Deleted Successfully'
        ]);
    }

    public function details(Request $request, $id){
        $table = Table::where("id", $id)->first();
        $status = "failed";
        $role_perms = [];
        $filter_roles = [];
        $perms = array(
            "read",
            "delete",
            "edit",
            "update"
        );

        // Role::where('name', 'admin')->first()->givePermissionTo("can edit blog");


        $roles = Role::all();

        foreach ($roles as $role){
            $role_perms[$role->name] = [];
            $filter_roles[] = $role->name;

            foreach ($perms as $perm){
                $full_perm = "can ". $perm. " ". $table->table_name;


                try{
                    if($role->hasPermissionTo($full_perm)){
                        $role_perms[$role->name][$perm] = true;
                    }else{
                        $role_perms[$role->name][$perm] = false;
                    }
                }catch (\Exception $e){
                    $role_perms[$role->name][$perm] = false;
                }
            }
        }

        if ($table != null){
            $status = "success";
        }



        return response()->json([
            'status' => $status,
            'data' => $table,
            'roles' => $filter_roles,
            'role_perms' => $role_perms
        ]);
    }



    public function create(Request $request){

        $fields = $request->fields;
        $configure_fields = $request->configure_fields;
        $table_name = $request->name;
        $display_name = $request->display_name;
        $model_name = ucfirst($table_name);

        tb_add_id_field($table_name);

        foreach ($fields as $field){

            $skipFields = array("id", "created_at", "updated_at");

            if (in_array($field['field_name'], $skipFields)){
                continue;
            }

            tb_add_column($table_name, $field, 'table');

        }

        tb_add_timestamps($table_name);

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


        cg_create_model($model_name, $table_name, $table_accepts_media);
        cg_create_resource($table_name, $fields);
        tb_create_perms($table_name);



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
        $perms = $request->perms;

        // Save perms
        tb_add_perms($table_name, $perms);



        // TODO: Save Perms


        // Delete fields if any
        $delete_fields = $request->delete_fields;


        if ($delete_fields != null){
            foreach($delete_fields as $field){
                tb_delete_column($table_name, $field);
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
            tb_add_column($table_name, $field, 'table');
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


            cg_delete_model($table_name);
            cg_create_resource($table_name, $fields);

            return response()->json([
                'status' => 'success',
                'message' => 'Table Updated',
                'details' => $request]);
        }





    }



}



