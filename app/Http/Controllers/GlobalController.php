<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class GlobalController extends Controller
{
    //change status global
    public function change_status(Request $request)
    {
        $id = $request->id;
        $action = $request->action;
        $table_name = $request->table_name;
        $next_status = "";
        $flag = "";
        $row = DB::table($table_name)->where('id', '=', $id)->get();
        $flag = $row[0]->$action;
        if ($flag == 1) {
            $next_status = 0;
        } else {
            $next_status = 1;
        }
        DB::table($table_name)->where('id', '=', $id)->update([$action => $next_status]);
        return "success";
    }

    function custom_delete(Request $request)
    {
        $table_name = $request->table_name;
        $model = $request->model;  // e.g., 'Survey', 'Property'
        $id = $request->id;

        // Convert the model name to the fully qualified class name
        $modelClass = 'App\\Models\\' . Str::studly($model);

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Model not found.'], 404);
        }

        $instance = app($modelClass)->find($id);

        if (!$instance) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        $instance->delete();
        if ($table_name != 'fonts') {
            DB::table($table_name)->where('id', '=', $id)->update(['is_active' => 0]);
        }

        return response()->json(['success' => 'Record deleted successfully.']);
    }


    public function row_reorder(Request $request)
    {
        foreach ($request->rows as $row) {
            DB::table($request->table_name)->where('id', $row['id'])->update(['order_num' => $row['position']]);
        }

        return response()->noContent();
    }
}
