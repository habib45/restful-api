<?php
namespace App\Repositories;

use App\Models\ExternalApi;


/**
 * Class ExternalApiRepository
 * @package App\Repositories
 */
class ExternalApiRepository  extends BaseRepository
{
    protected $modelName = ExternalApi::class;


    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name'
    ];


    /**
     * ExternalApiRepository constructor.
     * @param ExternalApi $model
     */
    public function __construct(ExternalApi $model)
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
    public function getExternalApisForIndex($request,$limit = 20)
    {
        $query = $this->getQuery();
        if ($request->filled('search')) {
            $query = $this->getSearchQuery($query,$request->search);
        }
        $query->orderBy('created_at', 'desc');
        if ($request->filled('per_page')) {
            $limit = $request->get('per_page');
        }
        return $query->paginate($limit);
    }
}
