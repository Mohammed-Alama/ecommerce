<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|unique:users,phone|regex:/^201[0-2-5]{1}[0-9]{8}/',
            'emergency_phone' => 'nullable|regex:/^201[0-2-5]{1}[0-9]{8}/',
            'whatsapp_phone' => 'nullable|regex:/^201[0-2-5]{1}[0-9]{8}/',
            'otp' => 'present',
            'is_company_user' => 'nullable|integer|in:0,1',
            'company_name' => 'required_if:is_company_user,1',
            'company_address' => 'required_if:is_company_user,1',
            'birth_date' => 'nullable|date',
            'national_ID' => 'nullable|digits:14'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'otp' => rand(000000, 999999),
        ]);
    }
}
