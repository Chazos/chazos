<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CollectionsController extends Controller
{
    public function manage(Request $request, $table){
        $columns = Schema::getColumnListing($table);
        $data = User::all();
        return view('admin.collections.manage', compact('table', 'columns', 'data'));
    }

    public function delete_item(Request $request, $table, $id){
        DB::table($table)->where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Record has been deleted successfully.']);
    }

    public function edit_item(Request $request, $table, $id){
        $collection =  DB::table($table)->where('id', $id)->first();
        $fields = json_decode(ContentType::where('collection_name', $table)->first()->fields);
        return view('admin.collections.edit', compact('table', 'collection', 'fields'));
    }

}
