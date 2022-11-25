<?php

namespace App\Http\Requests\API\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAPIRequest extends FormRequest
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
            'username' => 'required|unique:users,username,'.$this->id,
            'email' => "required|max:150|unique:users,email,".$this->id,
            'mobile' => 'required|max:20|unique:users,mobile,'.$this->id        ];
    }
}
