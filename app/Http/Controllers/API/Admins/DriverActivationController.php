<?php

namespace App\Http\Controllers\API\Admins;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverActivationController extends Controller
{
    public function __invoke(Request $request, Driver $driver)
    {
        $request->validate(['is_active' => 'required|boolean']);
        $driver->update(['is_active' => $request->input('is_active')]);

        return response()->json([
            'messasge' => 'Driver Updated Successfully',
            'data' => $driver
        ]);
    }
}
