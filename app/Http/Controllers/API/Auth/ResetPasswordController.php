<?php

namespace App\Http\Controllers\API\Auth;

use Str;
use Password;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    /**
     * Reset the given user's password.
     *
     * @param \App\Http\Requests\API\V1\Auth\ResetPasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {

        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == Password::PASSWORD_RESET
            ? $this->sendSuccessResponse($response)
            : $this->sendFailedResponse($response);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param \App\Http\Requests\API\V1\Auth\ResetPasswordRequest $request
     *
     * @return array
     */
    protected function credentials(ResetPasswordRequest $request)
    {
        return $request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string                                      $password
     *
     * @return void
     */
    protected function resetPassword(User $user, $password)
    {
        $user->password = $password;
        $user->setRememberToken(Str::random(60));
        $user->save();
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param                          $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendSuccessResponse($response)
    {
        return response()->json(['message' => trans($response)], 200);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param                          $response
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendFailedResponse($response)
    {
        return response()->json(['message' => trans($response)], 500);
    }
}
