<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;

class CustomActionController extends Controller
{
    public function get_actions(Request $request, $id)
    {
        $table = Table::where("id", $id)->first();

        return response()->json([
            'success' => true,
            'actions' => $table->actions,
        ]);
    }

    public function delete_action(Request $request, $id)
    {
        $table = Table::where("id", $id)->first();

        return response()->json([
            'success' => true,
            'actions' => $table->actions,
        ]);
    }
}
