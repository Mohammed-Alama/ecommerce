<?php

namespace App\Http\Controllers\API\General;

use App\Http\Controllers\Controller;
use App\Models\Region;

class RegionController extends Controller
{
    public function __invoke()
    {
        $regions = request()->has('city')
            ? Region::whereCityId(request()->query('city'))->get()
            : Region::all();

        return response()->json(['data' => $regions]);
    }
}
