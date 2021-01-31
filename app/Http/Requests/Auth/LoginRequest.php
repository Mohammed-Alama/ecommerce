<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => __('auth.failed'),
            'email.email' => __('auth.failed'),
            'email.string' => __('auth.failed'),
            'password.required' => __('auth.failed')
        ];
    }
}
