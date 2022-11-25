<?php

namespace App\Http\Requests\API\Users;

use App\Models\User;
use App\Http\Requests\ApiRequest;

class CreateUserAPIRequest extends ApiRequest
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
            'username' => 'required|unique:users|max:255',
            'email' => 'required|unique:users|max:150',
            'mobile' => 'required|string|unique:users|max:20',
            'password' => 'required|string|max:255',
//            'image' => 'required|string|max:20',
//            'designation' => 'required|string|max:255',
//            'activation_key' => 'required|string|max:255',
        ];
    }
}
