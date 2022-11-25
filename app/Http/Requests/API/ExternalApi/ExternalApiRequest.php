<?php

namespace App\Http\Requests\API\ExternalApi;

use Illuminate\Foundation\Http\FormRequest;

class ExternalApiRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'api_key' => 'required|string|max:100',
            'secret' => 'required|string|max:100',
            'url' => 'required|string|max:100',
            'key' => 'required|string|max:100',
        ];
    }
}
