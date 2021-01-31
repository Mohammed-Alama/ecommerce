<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\User;

class VerificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('throttle:6,1');
    }

    public function verify(Request $request)
    {

        $user =  User::findOrFail($request->route('id'));

        if (!hash_equals((string) $request->hash, sha1($user->email))) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => __('verification.email.already_verified')]);
        }

        $user->markEmailAsVerified();

        return redirect(env('SITE_URL') . '?msg=verified');
    }

    public function resend(Request $request)
    {

        if (auth_factory('user')->hasVerifiedEmail()) {
            return response()->json(['message' => __('verification.email.already_verified')]);
        }

        auth_factory('user')->sendEmailVerificationNotification();

        return response()->json(['message' => __('verification.email.sent')]);
    }
}
