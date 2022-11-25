<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class GroupResource
 * @package App\Http\Resources
 */
class GroupResource extends JsonResource
{

   /* private $pagination;


    public function __construct($resource)
    {
        $this->pagination = [
            'total' => $resource->total(),
            'count' => $resource->count(),
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'total_pages' => $resource->lastPage()
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }*/


    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array(
            'id'                =>  $this->id ?? null,
            'name'              =>  $this->name ?? null,
            'alias'             =>  $this->alias ?? null,
            'description'             =>  $this->description ?? null,
            'is_global'               =>  $this->is_global ?? null,
            'is_user_specific'              =>  $this->is_user_specific ?? null,
            'is_bypass_otp'                 =>  $this->is_bypass_otp ?? null,
            'is_super_group'                =>  $this->is_super_group ?? null,
            'is_special_user_group'             =>  $this->is_special_user_group ?? null,
            'special_user_key'                  =>  $this->special_user_key ?? null,
            'channels'          =>  $this->channels,
            'status'            =>  $this->status ?? null,
            'created_at'        =>  $this->created_at->format('Y-m-d H:i:s') ?? null,
            'updated_at'        =>  $this->updated_at->format('Y-m-d H:i:s') ?? null,
        );

    }

}
