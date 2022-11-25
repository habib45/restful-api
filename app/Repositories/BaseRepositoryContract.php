<?php

namespace App\Repositories;

/**
 * Interface BaseRepositoryContract
 * @package App\Repositories
 */
interface BaseRepositoryContract
{
    /**
     * Find a resource by id
     *
     * @param $id
     * @param $relation
     * @return Model|null
     */
    public function findOne($id, $relation);

    /**
     * Find a resource by criteria
     *
     * @param array $criteria
     * @return Model|null
     */
    public function findOneBy(array $criteria, $relation);


    /**
     * Search All resources by criteria
     *
     * @param array $searchCriteria
     * @param null $relation
     * @param array|null $orderBy
     * @return Collection
     */
    public function findBy(array $searchCriteria = [], $relation = null, array $orderBy = null);

    /**
     * Search All resources by any values of a key
     *
     * @param string $key
     * @param array $values
     * @param null $relation
     * @param array|null $orderBy
     * @return Collection
     */
    public function findIn($key, array $values, $relation = null, array $orderBy = null);

    /**
     * @param null $perPage
     * @param null $relation
     * @param array|null $orderBy
     * @return Collection
     */
    public function findAll($perPage = null, $relation = null, array $orderBy = null);

    /**
     * @param $id
     * @param null $relation
     * @param array|null $orderBy
     * @return mixed
     */
    public function findOrFail($id, $relation = null, array $orderBy = null);

    /**
     * @param array $params
     * @param array $fields Which fields to select
     * @return \Illuminate\Support\Collection|null|static
     */
    public function findByProperties(array $params, array $fields = ['*']);

    /**
     * Find resource
     *
     * @param array $params
     * @param array $fields Which fields to select
     * @return Model|null|static
     */
    public function findOneByProperties(array $params, array $fields = ['*']);



    /**
     * Find resources by ids
     *
     * @param array $ids
     * @return \Illuminate\Support\Collection|null|static
     */
    public function findByIds($ids);

    /**
     * Retrieve all resources
     *
     * @return \Illuminate\Support\Collection|null|static
     */
    public function getAll();

    /**
     * Save a resource
     *
     * @param array $data
     * @return Model
     */
    public function save(array $data);

    /**
     * Save resources
     *
     * @param array|Collection $resources
     * @return \Illuminate\Support\Collection|null|static
     */
    public function saveMany($resources);

    /**
     * @param $resource
     * @param $data
     * @return \Illuminate\Support\Collection|null|static
     */
    public function update($resource, $data = []);

    /**
     * Delete resources
     *
     * @param $resource
     * @return \Illuminate\Support\Collection|null|static
     */
    public function delete($resource);


    /**
     * Return model
     *
     * @return Model
     */
    public function getModel();

    /**
     * Creates a new model from properties
     *
     * @param array $properties
     * @return mixed
     */
    public function create(array $properties);
}
