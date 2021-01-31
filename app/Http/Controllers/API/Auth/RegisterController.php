<?php

namespace App\Http\Controllers\API\Auth;

use App\Events\Registered;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Support\Traits\IssueTokenTrait;
use App\Http\Requests\API\V1\Auth\RegisterRequest;

class RegisterController extends Controller
{
    use IssueTokenTrait;

    public function register(RegisterRequest $request)
    {
        $model = auth_factory('model');
        $user = $model::create($request->validated());

        Registered::dispatch($user);

        return response()->json([
            'message' => __('auth.account_created'),
            'data' => [
                'user' => $user,
                'token' => $this->getToken(
                    [
                        'email' => $request->validated()['email'],
                        'password' => $request->validated()['password'],
                    ]
                )
            ]
        ]);
    }
    /**
     * @param Request $request
     * @return void
     */
    public function refresh_token(Request $request)
    {
        return response()->json(
            [
                'token' => $this->getRefreshToken(
                    $request->input('refresh_token')
                )
            ]
        );
    }
}
