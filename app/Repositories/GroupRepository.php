<?php

namespace App\Repositories;

use App\Models\Group;


/**
 * Class GroupRepository
 * @package App\Repositories
 */
class GroupRepository  extends BaseRepository
{
    protected $modelName = Group::class;

    /**
     * @var array
     */
    protected $searchableField = [
        'id',
        'name',
        'description',
    ];


    /**
     * GroupRepository constructor.
     * @param Group $model
     */
    public function __construct(Group $model)
    {
        $this->model = $model;
    }


    /**
     * @return array
     */
    public function getSearchableFields()
    {
        return $this->searchableField;
    }



}
