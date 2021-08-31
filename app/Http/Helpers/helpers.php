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







