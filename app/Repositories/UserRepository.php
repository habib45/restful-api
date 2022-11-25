<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version August 22, 2022, 12:01 pm UTC
*/

class UserRepository extends BaseRepository
{
    protected $modelName = User::class;
//    protected $model;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'api_apps_id',
        'gp_user_id',
        'username',
        'name',
        'email',
        'mobile',
        'designation',
        'sys_user',
        'active_channel',
        'status'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

}
