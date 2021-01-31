<?php

namespace App\Http\Controllers\API\Auth;

use App\Core\SMSServices\Contracts\SMSGateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhoneController extends Controller
{

    public function verify(Request $request, SMSGateway $gateway)
    {
        if (auth_factory('user')->hasVerifiedPhone()) {
            return response()->json(['message' => __('verification.phone.already_verified')]);
        }
        $valid_data = $request->validate([
            'verification_code' => 'required|numeric',
        ]);

        try {
            $check = $gateway->verify($valid_data['verification_code']);
            if (!$check) {
                return response()->json(
                    ['message' => __('verification.phone.code_wrong')],
                    422
                );
            }
            auth_factory('user')->markPhoneVerified();
        } catch (\Exception $exception) {
            return response()->json(
                ['message' => __('verification.errors.too_many_requests')],
                429
            );
        }
        return response()->json(['message' => __('verification.phone.verified')]);
    }


    public function send(Request $request, SMSGateway $gateway)
    {
        if (auth_factory('user')->hasVerifiedPhone()) {
            return response()->json(['message' => __('verification.phone.already_verified')]);
        }
        try {
            $gateway->otp();
        } catch (\Exception $exception) {
            return response()->json(['message' => __('errors.too_many_requests')], 429);
        }

        return response()->json(['message' => __('verification.phone.sent')]);
    }
}
