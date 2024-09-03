<?php

namespace App\Http\Controllers\Api;

use App\Enums\ApplicationType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ApplicationTypeController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->has('lang'))
            App::setLocale($request->get('lang'));

        return response()->json([
            'data'   => ApplicationType::select(),
            'status' => true
        ]);
    }
}
