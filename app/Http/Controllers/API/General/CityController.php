<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\City;

class CityController extends Controller
{

    public function __invoke()
    {
        return response()->json(['data' => City::all()->toArray()]);
    }
}
