<?php

namespace App\Http\Controllers;

use App\Events\CustomAction;
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

    public function trigger_action(Request $request, $action, $table, $id)
    {
        try {
            CustomAction::dispatch($action, $table, $id);
            return response()->json([
                'status' => 'success',
                'message' => "Action was completed successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);
        } catch (\Error $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
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
