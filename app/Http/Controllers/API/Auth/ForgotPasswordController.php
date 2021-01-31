<?php

namespace App\Http\Controllers\API\Auth;

use Password;
use App\Http\Controllers\Controller;
use App\Support\Auth\AuthProviderFactory;
use App\Http\Requests\Auth\ForgetPasswordRequest;

class ForgotPasswordController extends Controller
{

    public function sendResetLinkEmail(ForgetPasswordRequest $request, AuthProviderFactory $auth_factory)
    {
        $model =  $auth_factory->getModel();
        $user = $model::query()->whereEmail($request->input('email'))->firstOrFail();

        $response = $this->broker()->sendResetLink(['email' => $user->email]);

        return $response == Password::RESET_LINK_SENT
            ? $this->sendSuccessResponse($response, $user->email)
            : $this->sendFailedResponse($response);
    }

    public function broker()
    {
        return Password::broker();
    }

    protected function sendSuccessResponse($response, $email)
    {
        [$name, $domain] = explode("@", $email);
        $length = strlen($name) / 2;
        $email =  substr($name, 0, $length) . str_repeat('*', $length) . '@' . $domain;

        return response()->json([
            'message' => trans($response, ['email' => $email]),
        ], 200);
    }

    protected function sendFailedResponse($response)
    {
        return response()->json(['message' => trans($response)], 500);
    }
}
