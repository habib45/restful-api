<?php

namespace App\Http\Resources;

use App\Models\GroupsUser;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 */
class UserResource extends JsonResource
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
            'id'            => $this->id ?? null,
            'api_apps_id'   => $this->api_apps_id ?? null,
            'gp_user_id'   => $this->gp_user_id ?? null,
            'username'      => $this->username ?? null,
            'name'          => $this->name ?? null,
            'email'         => $this->email ?? null,
            'bio'           => $this->bio ?? null,
            'image'         => $this->image ?? null,
            'mobile'        => $this->mobile ?? null,
            'designation'   => $this->designation ?? null,
            'status'        => $this->status ?? null,
            'activation_key' => $this->activation_key ?? null,
            'is_email_verified' => $this->is_email_verified ?? null,
            'email_notification_enable' => $this->email_notification_enable ?? null,
            'sms_notification_enable' => $this->sms_notification_enable ?? null,
            'status' => $this->status ?? null,
            'sys_user' => $this->sys_user ?? null,
            'active_channel' => $this->active_channel ?? null,
            'groups' =>[], //$this->groupDataFormeteForSelectBox($this->get_user_groups),
            'created_at'   =>  date('d-m-Y h:i A', strtotime($this->created_at))?? null,
            'updated_at'   =>  date('d-m-Y h:i A', strtotime($this->updated_at))?? null,
        ];

    }






}
