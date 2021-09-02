<?php

use App\Models\Table;
use Illuminate\Support\Facades\File;

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

if (! function_exists('delete_model')) {
    function delete_model( $table_name ) {
        $model_name = ucfirst($table_name);
        $model_file = base_path() . '/app/Models/' . $model_name . '.php';
        File::delete($model_file);
    }
}



if (! function_exists('create_model')) {
    function create_model( $model_name, $table_name, $accept_media=false ) {

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
        $model_string .= "}\n";


        File::put(base_path() . '/app/Models/' . $model_name . '.php', $model_string);
    }
}







