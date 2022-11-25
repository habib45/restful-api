<?php

namespace App\Repositories;

use App\Models\Channel;


/**
 * Class GroupRepository
 * @package App\Repositories
 */
class ChannelRepository  extends BaseRepository
{
    protected $modelName = Channel::class;

    protected $fieldSearchable = [
        'id',
        'name',
        'namespace',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];


    /**
     * GroupRepository constructor.
     * @param Group $model
     */
    public function __construct(Channel $model)
    {
        $this->model = $model;
    }

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
     * get query object 
     * @return Query
     */
    public function getQuery()
    {
        return $this->model->getQuery();
    }

    /**
     * get query object 
     */
    public function getSearchQuery($query,$keyWord)
    {
        if($keyWord)
        {
            foreach($this->fieldSearchable as $field)
            {
                $query->orWhere($field, 'LIKE', "%{$keyWord}%");
            }
        }
        return $query;
    }

    public function getChannelsForIndex($request,$limit = 20)
    {
        $query = $this->getQuery();
        if ($request->filled('search')) {
            $query = $this->getSearchQuery($query,$request->search);
        }
        if ($request->filled('per_page')) {
            $limit = $request->get('per_page');
        }
        return $query->paginate($limit);
    }
}
