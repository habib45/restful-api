<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupsUser extends Model
{
    use HasFactory;

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql';


    /**
     * @var string
     */
    protected $table = "groups_users";

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'group_id',
        'user_id',
    ];

    /**
     * @return mixed
     */
    public function getGroups(){
        return $this->hasMany(Group::class, 'group_id','id');
    }

    /**
     * @return mixed
     */
    public function groups(){
        return $this->hasMany(Group::class, 'group_id','id');
    }
}
