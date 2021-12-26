<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use App\Events\DashTableCreated;
use App\Events\DashTableUpdated;
use App\Events\DashTableDeleted;

class TableController extends Controller
{
    //

    public function index(){
        $tables = Table::all();
        return view('admin.tables.index', ['tables' => $tables]);
    }

    public function rename_table(Request $request, $table_name){

        $new_table_name = $request->input('table_name');
        $new_display_name = $request->input('display_name');

        $table = Table::where('table_name', $table_name)->first();
        $fields = json_decode(json_encode(json_decode($table->fields)), true);



        $table_name = $table->table_name;
        $model_name = ucfirst($new_table_name);
        $table_accepts_media = cg_supports_media($fields);

        // Delete table model, resource and perms
        cg_delete_model($table_name);
        cg_delete_resource($table_name);
        tb_delete_perms($table_name);

        // Rename table
        Schema::rename($table_name, $new_table_name);
        $table->table_name = $new_table_name;
        $table->display_name = $new_display_name;
        $table->model_name = $model_name;
        $table->save();

        $table_name = $new_table_name;

        // Recreate models, resource and perms
        cg_create_model($model_name, $table_name, $table_accepts_media);
        cg_create_resource($table_name, $fields);
        tb_create_perms($table_name);

        return response()->json([

            'status' => 'success',
            'message' => 'Table renamed successfully',
            'data' => [
                'id' => $table->id,
            ]
        ]);
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

        DashTableDeleted::dispatch($table);


        return response()->json([
            'status' => 'success',
            'message' => 'Table Deleted Successfully'
        ]);
    }

    public function get_all_tables(){
        $tables = Table::all();
        return response()->json([
            'status' => 'success',
            'tables' => $tables
        ]);
    }

    public function details(Request $request, $id){
        $table = Table::where("id", $id)->first();
        $status = "failed";
        $role_perms = [];
        $filter_roles = [];
        $perms = array(
            "create",
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
                    Permission::create(['name' => $full_perm]);
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
        $table_keys = $request->keys;

        // Add fields
        tb_add_id_field($table_name);

        foreach ($fields as $field){
            $skipFields = array("id", "created_at", "updated_at");

            if (in_array($field['field_name'], $skipFields)){
                continue;
            }
            tb_add_column($table_name, $field, 'table');
        }


        // Add foreign and delete
        $table_keys = $this->add_and_drop_foreign_keys($table_keys, $table_name);

        tb_add_timestamps($table_name);

        // Save table details to the database
        $new_table = new Table();

        $new_table->display_name = $display_name;
        $new_table->model_name = $model_name;
        $new_table->table_name = $table_name;
        $new_table->slug = $table_name;
        $new_table->fields = json_encode($fields);
        $new_table->keys = json_encode($table_keys);
        $new_table->actions = json_encode(array());
        $new_table->configure_fields = json_encode($configure_fields);
        $new_table->save();


        // Create model for table
        $table_accepts_media = cg_supports_media($fields);


        cg_create_model($model_name, $table_name, $table_accepts_media);
        cg_create_resource($table_name, $fields);
        tb_create_perms($table_name);
        cg_create_import($model_name);
        cg_create_export($model_name);

        DashTableCreated::dispatch($new_table);



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
        $table_keys = $request->keys;
        $table_actions = $request->actions;
        $model_name = ucfirst($table_name);
        $table_accepts_media = cg_supports_media($fields);



        // Save perms
        tb_add_perms($table_name, $perms);


        // Delete fields if any
        $delete_fields = $request->delete_fields;


        if ($delete_fields != null){
            foreach($delete_fields as $field){
                tb_delete_column($table_name, $field);
            }
        }

        // Rename fields if any
        $edit_fields = $request->edit_fields;

        if ($edit_fields != null){
            foreach($edit_fields as $field){
                $old_name = $field['old_field_name'];
                $new_name = $field['field_name'];
                tb_rename_column($table_name, $old_name, $new_name);
                tb_add_column($table_name, $field, 'table', true);
            }
        }

        // Add foreign and delete
        $table_keys = $this->add_and_drop_foreign_keys($table_keys, $table_name);


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
            $update_collection->keys = json_encode($table_keys);
            $update_collection->actions = $table_actions;
            $update_collection->save();



            cg_create_model($model_name, $table_name, $table_accepts_media);
            cg_create_resource($table_name, $fields);

            DashTableUpdated::dispatch($table_name, $update_collection);

            return response()->json([
                'status' => 'success',
                'message' => 'Table Updated',
                'details' => $request]);
        }





    }

    private function add_and_drop_foreign_keys($table_keys, $table_name){
        if ($table_keys == NULL){
            return [];
        }

        for ($i=0; $i < count($table_keys); $i++) {
            $key = $table_keys[$i];

            if ($key['key_type'] == 'foreign_key'){
                if ($key['is_new'] == true){
                    tb_add_foreign_key($table_name, $key);
                    $key['is_new'] = false;
                }


                if ($key['is_deleted'] == true)
                    tb_drop_foreign($table_name, $key['column_name']);
                    unset($table_keys[$i]);
            }
        }

        return $table_keys;
    }



}



