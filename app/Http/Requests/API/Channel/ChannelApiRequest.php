<?php

namespace App\Http\Requests\API\Channel;

use App\Models\User;
use App\Http\Requests\ApiRequest;

class ChannelApiRequest extends ApiRequest
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
     *`
     * @return array
     */

    public function rules()
    {
        return [
            'track_id' => 'required',
            'name' => 'required|string|max:255',
            'namespace' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'status' => 'nullable|string|max:50',
        ];
    }
}
