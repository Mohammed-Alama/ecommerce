<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;


class AddressRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->address
            ? auth_factory('user')->id == $this->address->user_id
            : true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'region_id' => 'required|exists:regions,id'
        ];
    }
}
