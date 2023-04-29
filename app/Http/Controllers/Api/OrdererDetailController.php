<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrdererDetailRequest;
use Illuminate\Http\Request;

class OrdererDetailController extends Controller
{
    public function __construct()
    {

    }

    public function __invoke(OrdererDetailRequest $request)
    {
        $modelClass = $request->type;
        $modelId = $request->id;

        if ($model = $modelClass::find($modelId)) {
            return $model;
        }

        return response()->json([], 404);
    }
}
