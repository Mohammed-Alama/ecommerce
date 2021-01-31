<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->product) {
            auth_factory('user')->id == $this->product->merchant_id;
        }
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
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric',
            'is_active' => 'required|boolean'
        ];
    }


    public function prepareForValidation()
    {
        return $this->merge([
            'slug' => Str::slug($this->input('name'))
        ]);
    }
}
