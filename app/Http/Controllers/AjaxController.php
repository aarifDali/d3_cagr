<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Response;

class AjaxController extends Controller
{
    //
    public function status(Request $request)
    {
        $status = $request->status == '1' ? '0' : '1';
        DB::table($request->table)->where('id', $request->id)->update(['status' => $status, 'updated_by' => Auth::guard('web')->user()->id]);
        return $status;
    }


    public function type(Request $request)
        {
            $type = $request->type;

            DB::table($request->table)->where('id', $request->id)->update(['type' => $type, 'updated_by' => Auth::guard('web')->user()->id]);

            return $type;
        }

    public function checkExistence(Request $request)
    {
        $isAvailable = true;
        $field = $request->type;
        if($request->id) {
            if(DB::table($request->table)->where([[$field, '=', $request->$field], ['id', '<>', $request->id]])->exists())
                $isAvailable = false;
        } else {
            if(DB::table($request->table)->where($field, '=', $request->$field)->exists())
                $isAvailable = false;
        }
        return json_encode(['valid' => $isAvailable]);
    }
}
