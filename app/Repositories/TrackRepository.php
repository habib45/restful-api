<?php
namespace App\Repositories;

use App\Models\Track;


/**
 * Class TrackRepository
 * @package App\Repositories
 */
class TrackRepository  extends BaseRepository
{
    protected $modelName = Track::class;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'description',
    ];


    /**
     * TrackRepository constructor.
     * @param Track $model
     */
    public function __construct(Track $model)
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


    /**
     * @param $request
     * @param int $limit
     * @return mixed
     */
    public function getTracksForIndex($request,$limit = 20)
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
