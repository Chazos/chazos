<?php

use App\Models\Settings;
use App\Models\Table;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

if (! function_exists('cg_get_collections')) {
    function cg_get_collections()
    {
        return Table::all();
    }
}

if (! function_exists('cg_slugify')) {
    function cg_slugify( $section ) {

        $section = preg_replace( '([^A-Za-z0-9])', '_', $section );
        $section = str_replace( '--', '_', $section );
        return $section;

    }
}

if (! function_exists('cg_get_project_logo')) {
    function cg_get_project_logo(  ) {

        $setting = Settings::where('name', 'site_image')->first();

        if( $setting ) {
            return $setting->value;
        }else{
            return '';
        }

    }
}

if (! function_exists('cg_unslugify')) {
    function cg_unslugify( $slug ) {

        $slug = str_replace( '-', ' ', $slug );
        $slug = str_replace( '_', ' ', $slug );
        return ucwords( $slug );
    }
}

if (! function_exists('cg_supports_media')) {
    function cg_supports_media( $fields) {

        foreach( $fields as $field ) {
            if ($field['accepts_file'] == "true"){
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('cg_delete_model')) {
    function cg_delete_model( $table_name ) {
        $model_name = ucfirst($table_name);
        $model_file = base_path() . '/app/Models/' . $model_name . '.php';
        File::delete($model_file);
    }
}

if (! function_exists('cg_delete_model')) {
    function cg_delete_model( $table_name ) {
        $model_name = ucfirst($table_name);
        $model_file = base_path() . '/app/Models/' . $model_name . '.php';
        File::delete($model_file);
    }
}

if (! function_exists('cg_delete_table')) {
    function cg_delete_table( $table_name ) {
        Schema::dropIfExists($table_name);
    }
}



if (! function_exists('cg_create_model')) {
    function cg_create_model( $model_name, $table_name, $accept_media=false ) {

        $model_string = "<?php\nnamespace App\Models;";
        $model_string .= "\n\n";
        $model_string .= "use Illuminate\Database\Eloquent\Model;\n";

        // Add libs if model supports media
        if ( $accept_media ) {
            $model_string .= "use Spatie\MediaLibrary\HasMedia;\n";
            $model_string .= "use Spatie\MediaLibrary\InteractsWithMedia;\n\n";
            $model_string .= "class $model_name extends Model implements HasMedia{\n";
        }else{
            $model_string .= "class $model_name extends Model{\n";
        }

        // Add trait if model supports media
        if ( $accept_media ) {
            $model_string .= "\tuse InteractsWithMedia;\n";
        }


        $model_string .= "\tprotected \$table = '$table_name';\n";
        $model_string .= "\tprotected \$guarded = array();";
        $model_string .= "}\n";


        File::put(base_path() . '/app/Models/' . $model_name . '.php', $model_string);
    }
}

if (! function_exists('cg_create_export')) {
    function cg_create_export( $model_name) {
        $export_name = $model_name . "Export";

        $exitCode = Artisan::call("make:export $export_name --model=$model_name");
    }
}

if (! function_exists('cg_create_import')) {
    function cg_create_import( $model_name) {
        $import_name = $model_name . "Import";

        $exitCode = Artisan::call("make:import $import_name --model=$model_name");
    }
}

if (! function_exists('cg_delete_import')) {
    function cg_delete_import( $model_name ) {
        $import_name = $model_name . "Import";

        $resource_file = base_path() . '/app/Imports/' . $import_name . '.php';
        File::delete($resource_file);
    }
}

if (! function_exists('cg_delete_export')) {
    function cg_delete_export( $model_name ) {
        $export_name = $model_name . "Export";

        $resource_file = base_path() . '/app/Exports/' . $export_name . '.php';
        File::delete($resource_file);
    }
}

if (! function_exists('cg_delete_resource')) {
    function cg_delete_resource( $table_name ) {
        $resource_name = ucfirst($table_name) . 'Resource';
        $resource_file = base_path() . '/app/Http/Resources/' . $resource_name . '.php';
        File::delete($resource_file);
    }
}

if (! function_exists('cg_get_setting')) {
    function cg_get_setting( $name ) {
        $setting = Settings::where('name', $name)->first();

        if ( $setting ) {
             return $setting->value;
        }else{
            return '';
        }
    }
}

if (! function_exists('cg_create_resource')) {
    function cg_create_resource( $table_name, $fields ) {
        $res_name = ucfirst($table_name) . "Resource";

        $res_string = "<?php \nnamespace App\Http\Resources;";
        $res_string .= "use Illuminate\Http\Resources\Json\JsonResource;\n\n";
        $res_string .= "class $res_name extends JsonResource {\n";
        $res_string .= "\tpublic function toArray(\$request) {\n";

        $res_string .= "\t\treturn [\n";
        $res_string .= "\t\t\t'id' => \$this->id,\n";

        foreach( $fields as $field ) {
            $field_name = $field['field_name'];
            $accepts_file = $field['accepts_file'];

            if ($accepts_file == "true"){
                $res_string .= "\t\t\t'$field_name' => \$this->getMedia('$field_name'),\n";
            }else{
                $res_string .= "\t\t\t'$field_name' => \$this->$field_name,\n";
            }
        }

        $res_string .= "\t\t\t'created_at' => \$this->created_at,\n";
        $res_string .= "\t\t\t'updated_at' => \$this->updated_at\n";

        $res_string .= "\t\t];\n";
        $res_string .= "\t}\n";
        $res_string .= "}\n";

        File::put(base_path() . '/app/Http/Resources/' . $res_name . '.php', $res_string);
    }
}

if (! function_exists('cg_set_env_variable')) {
    function cg_set_env_variable($env_name, $config_key, $new_value) {
        file_put_contents(App::environmentFilePath(), str_replace(
            $env_name . '=' . Config::get($config_key),
            $env_name . '=' . $new_value,
            file_get_contents(App::environmentFilePath())
        ));

        Config::set($config_key, $new_value);

        // Reload the cached config
        if (file_exists(App::getCachedConfigPath())) {
            Artisan::call("config:cache");
        }
    }
}


abstract class PaymentStatus{
    const pending = "PENDING";
    const paid = "PAID";
    const failed = "FAILED";
    const timeout_reached = "TIMEOUT_REACHED";
    const cancelled = "CANCELLED";
    const transit = "IN TRANSIT";
    const delivered = "DELIVERED";
    const returned = "RETURNED";
    const rejected = "REJECTED";
    const expired = "EXPIRED";
    const unknown = "UNKNOWN";
}

