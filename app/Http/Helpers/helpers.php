<?php

use App\Models\ContentType;

if (! function_exists('get_collections')) {
    function get_collections()
    {
        return ContentType::all();
    }
}

if (! function_exists('slugify')) {
    function slugify( $section ) {

        $section = preg_replace( '([^A-Za-z0-9])', '_', $section );
        $section = str_replace( '--', '_', $section );
        return $section;

    }
}

if (! function_exists('unslugify')) {
    function unslugify( $slug ) {

        $slug = str_replace( '-', ' ', $slug );
        $slug = str_replace( '_', ' ', $slug );
        return ucwords( $slug );
    }
}

if (! function_exists('supports_media')) {
    function supports_media( $fields) {

        foreach( $fields as $field ) {
            if ($field['default'] == "true"){
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('create_model')) {
    function create_model( $model_name, $table_name, $accept_media=false ) {

        $model_string = "namespace App\Models;";
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
            $model_string .= "use InteractsWithMedia;\n";
        }


        $model_string .= "protected \$table = '$table_name';\n";
        $model_string .= "}\n";


        $model_file = fopen( "app/Models/$model_name.php", "w" );
        fwrite( $model_file, $model_string );
        fclose( $model_file );
    }
}







