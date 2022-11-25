<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'api_apps_id',
        'gp_user_id',
        'username',
        'password',
        'name',
        'email',
        'bio',
        'image',
        'mobile',
        'designation',
        'activation_key',
        'reset_code',
        'is_email_verified',
        'email_notification_enable',
        'sms_notification_enable',
        'timezone',
        'sys_user',
        'active_channel',
        'status',
        'remember_token',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
        'timezone',
        'deleted_at',
        'reset_code',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return mixed
     */
    public function groups(){
        return $this->belongsToMany(Group::class,'groups_users','user_id','group_id');
//            return $this->hasManyThrough(
//                Group::class, // the pivot model
//                GroupsUser::class, // the related model
//                'user_id', // the current model id in the pivot
//                'id',// the id of related model
//                'id', // the id of current model
//                'group_id' // the related model id in the pivot
//            );
    }
}

