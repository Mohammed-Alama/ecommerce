<?php

namespace App\Http\Controllers\API\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Support\Traits\IssueTokenTrait;



class LoginController extends Controller
{
    use IssueTokenTrait;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
        ]);

        $model =  auth_factory('model');
        $user = $model::query()->whereEmail($request->input('email'))->firstOrFail();

        return response()->json([
            'message' => __('auth.successful', ['user' => $user->name]),
            'data' => $this->getToken(
                [
                    'email' => $user->email,
                    'password' => $request->input('password'),
                ]
            ),
        ]);
    }

    public function logout()
    {
        auth_factory('user')->token()->revoke();

        return response()->json([
            'message' => __('auth.logout'),
        ]);
    }
}
