<?php

namespace App\Http\Controllers\Api\Lsbl\Serv12;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lsbl\Serv12\Lfb011;

class Lfb011Controller extends Controller
{
    public function list(Request $request)
    {
        return response()->json([
            'res' => true,
            'result' => [
                'data' => Lfb011::get()
            ]
        ]);
    }

    public function open(Request $request, $Id_global)
    {
        return response()->json([
            'res' => true,
            'result' => [
                'data' => Lfb011::find($Id_global)
            ]
        ]);
    }
}
