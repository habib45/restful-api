<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;


abstract class BaseRepository  implements BaseRepositoryContract
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
        $this->setModel();
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
//    abstract public function getFieldsSearchable();

    /**
     * Configure the Model
     *
     * @return string
     */
//    abstract public function model();

    /**
     * Make Model instance
     *
     * @throws \Exception
     *
     * @return Model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }


    /**
     * Instantiate Model
     *
     * @throws \Exception
     */
    public function setModel()
    {
        //check if the class exists
        if (class_exists($this->modelName)) {
            return  $this->model = new $this->modelName();

            //check object is a instanceof Illuminate\Database\Eloquent\Model
            if (!$this->model instanceof Model) {
                throw new \Exception("{$this->modelName} must be an instance of Illuminate\Database\Eloquent\Model");
            }
        } else {
            throw new \Exception('No model name defined');
        }
    }

    /**
     * Get Model instance
     *
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }
    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'])
    {
        $query = $this->allQuery();

        return $query->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }

    /**
     * Find a resource by id
     *
     * @param $id
     * @param null $relation
     * @return Model|null
     */
    public function findOne($id, $relation = null)
    {
        return $this->findOneBy(['id' => $id], $relation);
    }

    /**
     * @param $id
     * @param null $relation
     * @param array|null $orderBy
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|Collection|Model|Model[]|mixed
     */
    public function findOrFail($id, $relation = null, array $orderBy = null)
    {
        return $this->prepareModelForRelationAndOrder($relation, $orderBy)->findOrFail($id);
    }

    /**
     * Find resource
     *
     * @param $field
     * @param $value
     * @return \Illuminate\Support\Collection|null|static
     */
    public function findBy(array $searchCriteria = [], $relation = null, array $orderBy = null)
    {
        $model = $this->prepareModelForRelationAndOrder($relation, $orderBy);
        $limit = !empty($searchCriteria['per_page']) ? (int)$searchCriteria['per_page'] : 15; // it's needed for pagination

        $queryBuilder = $model->where(function ($query) use ($searchCriteria) {

            $this->applySearchCriteriaInQueryBuilder($query, $searchCriteria);
        });
        if (!empty($searchCriteria['per_page'])) {
            return $queryBuilder->paginate($limit);
        }
        return $queryBuilder->get();
    }

    /**
     * Search All resources by any values of a key
     *
     * @param string $key
     * @param array $values
     * @return Collection
     */
    public function findIn($key, array $values, $relation = null, array $orderBy = null)
    {
        return $this->prepareModelForRelationAndOrder($relation, $orderBy)->whereIn($key, $values)->get();
    }


    /**
     * @param null $perPage
     * @param null $relation
     * @param array|null $orderBy
     * @return Contracts\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|Collection|Model[]
     */
    public function findAll($perPage = null, $relation = null, array $orderBy = null)
    {
        $model = $this->prepareModelForRelationAndOrder($relation, $orderBy);
        if ($perPage) {
            return $model->paginate($perPage);
        }

        return $model->get();
    }
    /**
     * Find resource
     *
     * @param array $params
     * @param array $fields Which fields to select
     * @return \Illuminate\Support\Collection|null|static
     */
    public function findByProperties(array $params, array $fields = ['*'])
    {
        $query = $this->model->query();

        foreach ($params as $key => $value) {
            $query->where($key, $value);
        }

        return $query->get($fields);
    }

    /**
     * Find resource
     *
     * @param array $params
     * @param array $fields Which fields to select
     * @return Model|null|static
     */
    public function findOneByProperties(array $params, array $fields = ['*'])
    {
        $query = $this->model->query();

        foreach ($params as $key => $value) {
            $query->where($key, $value);
        }

        return $query->first($fields);
    }

    /**
     * Find a resource by criteria
     *
     * @param array $criteria
     * @param null $relation
     * @return Model|null
     */
    public function findOneBy(array $criteria, $relation = null)
    {
        return $this->prepareModelForRelationAndOrder($relation)->where($criteria)->first();
    }

    /**
     * Find resources by ids
     *
     * @param array $ids
     * @return \Illuminate\Support\Collection|null|static
     */
    public function findByIds($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * Retrieve all resources
     *
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getAll()
    {
        return $this->model->get();
    }

    /**
     * Save a resource
     *
     * @param array $data
     * @return Model
     */
    public function save(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Save resources
     *
     * @param array|Collection $resources
     * @return mixed
     */
    public function saveMany($resources)
    {
        DB::transaction(function () use ($resources) {
            foreach ($resources as $resource) {
                $this->save($resource);
            }
        });
    }

    /**
     * Update resource
     *
     * @param $resource
     * @param $data
     * @return \Illuminate\Support\Collection|null|static
     */
    public function update($resource, $data = [])
    {
        if (is_array($data) && count($data) > 0) {
            $resource->fill($data);
        }

        $this->save($resource);

        return $resource;
    }

    /**
     * Delete resource
     *
     * @param $resource
     * @return \Illuminate\Support\Collection|null|static
     */
    public function delete($resource)
    {
        $resource->delete();

        return $resource;
    }



    /**
     * Creates a new model from properties
     *
     * @param array $properties
     * @return mixed
     */
    public function create(array $properties)
    {
        if (is_array($properties) && count($properties)) {
            return $this->model->create($properties);
        }

        return null;
    }

    /**
     * @param $relation
     * @param array|null $orderBy [[Column], [Direction]]
     * @return \Illuminate\Database\Eloquent\Builder|Model
     */
    private function prepareModelForRelationAndOrder($relation, array $orderBy = null)
    {
        $model = $this->model;
        if ($relation) {
            $model = $model->with($relation);
        }
        if ($orderBy) {
            $model = $model->orderBy($orderBy['column'], $orderBy['direction']);
        }
        return $model;
    }

    /**
     * Apply condition on query builder based on search criteria
     *
     * @param Object $queryBuilder
     * @param array $searchCriteria
     * @return mixed
     */
    protected function applySearchCriteriaInQueryBuilder($queryBuilder, array $searchCriteria = [])
    {

        foreach ($searchCriteria as $key => $value) {

            //skip pagination related query params
            if (in_array($key, ['page', 'per_page'])) {
                continue;
            }

            //we can pass multiple params for a filter with commas
            $allValues = explode(',', $value);

            if (count($allValues) > 1) {
                $queryBuilder->whereIn($key, $allValues);
            } else {
                $operator = '=';
                $queryBuilder->where($key, $operator, $value);
            }
        }

        return $queryBuilder;
    }


    /**
     * Find model record for given id
     *
     * @param int $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }


    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->model->query()->getQuery()->from;
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
            foreach($this->getSearchableFields as $field)
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
    public function getItemsForIndex($request,$limit = 20)
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
