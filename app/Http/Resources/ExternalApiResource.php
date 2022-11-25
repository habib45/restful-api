<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 */
class ExternalApiResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id ?? null,
            'name'=> $this->name ?? null,
            'is_form_field_mapped_api'=> $this->is_form_field_mapped_api ?? false,
            'key'=> $this->key ?? null,
            'status' => $this->status ?? null,
            'created_at' =>date('d-m-Y h:i A', strtotime($this->created_at))?? null,
            'updated_at' =>date('d-m-Y h:i A', strtotime($this->updated_at))?? null,
        ];
    }
}
