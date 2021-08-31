<?php

use App\Models\ContentType;

if (! function_exists('get_collections')) {
    function get_collections()
    {
        return ContentType::all();
    }
}
