<?php

namespace App\Repositories;

use App\Models\Channel;
use App\Models\Project;

/**
 * Class GroupRepository
 * @package App\Repositories
 */
class ProjectRepository  extends BaseRepository
{
    protected $modelName = Project::class;

    /**
     * GroupRepository constructor.
     * @param Group $model
     */
    public function __construct(Project $model)
    {
        $this->model = $model;
    }
}
