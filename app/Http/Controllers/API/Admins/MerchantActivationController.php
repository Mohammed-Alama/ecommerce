<?php

namespace App\Http\Controllers\API\Admins;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantActivationController extends Controller
{
    public function __invoke(Request $request, Merchant $merchant)
    {
        $request->validate(['is_active' => 'required|boolean']);
        $merchant->update(['is_active' => $request->input('is_active')]);

        return response()->json([
            'messasge' => 'Merchant Updated Successfully',
            'data' => $merchant
        ]);
    }
}
