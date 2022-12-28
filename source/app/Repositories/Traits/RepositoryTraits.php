<?php

namespace App\Repositories\Traits;

trait RepositoryTraits
{
    /**
     * Function buildQuery
     *
     * @param $model
     * @param $filters
     * @return mixed
     */
    abstract public function buildQuery($model, $filters);

    /**
     * Function firstByWhere
     *
     * @param $where
     * @param array $relationship
     * @param string $columns
     * @return \Illuminate\Database\Eloquent\Model |null
     */
    public function firstByWhere($where, $relationship = [], $columns = "*")
    {
        $this->applyCriteria();
        $this->applyScope();
        $this->applyConditions($where);

        $model = $this->model;

        $model = $this->buildRelationShip($model, $relationship);
        $model = $model->first($columns);
        $this->resetModel();

        if ($model) {
            return $this->parserResult($model);
        }

        return null;
    }


    /**
     * Function firstById
     *
     * @param $id
     * @param array $relationship
     * @return \Illuminate\Database\Eloquent\Model |null
     */
    public function firstById($id, $relationship = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;

        $model = $this->buildRelationShip($model, $relationship);
        $model = $model->find($id);

        $this->resetModel();

        if ($model) {
            return $this->parserResult($model);
        }

        return null;
    }

    /**
     * Function multiDelete
     *
     * @param $ids
     * @param $relationship
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed|null
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function multiDelete($ids, $relationship = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;

        $model = $this->buildRelationShip($model, $relationship);
        $model = $model->whereIn('id', $ids)->delete();

        $this->resetModel();

        if ($model) {
            return $this->parserResult($model);
        }

        return null;
    }


    /**
     * Function firstByFilters
     *
     * @param array $filters
     * @param array $relationship
     * @param array $orderBy
     * @return \Illuminate\Database\Eloquent\Collection | null
     */
    public function firstByFilters($filters = [], $relationship = [], $orderBy = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $this->buildRelationShip($model, $relationship);
        $model = $this->buildOrderBy($model, $orderBy);
        $model = $model->first();

        $this->resetModel();

        return $this->parserResult($model);
    }


    /**
     * Function firstByFiltersWithTrashed
     *
     * @param array $filters
     * @param array $relationship
     * @param array $orderBy
     * @return \Illuminate\Database\Eloquent\Collection | null
     */
    public function firstByFiltersWithTrashed($filters = [], $relationship = [], $orderBy = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $this->buildRelationShip($model, $relationship);
        $model = $this->buildOrderBy($model, $orderBy);
        $model = $model->withTrashed()->first();

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Function getByFilters
     *
     * @param array $filters
     * @param array $relationship
     * @param int $limit
     * @param int $offset
     * @param array $orderBy
     * @return \Illuminate\Database\Eloquent\Collection | null
     */
    public function getByFilters($filters = [], $relationship = [], $limit = 10, $offset = 0, $orderBy = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $this->buildRelationShip($model, $relationship);
        $model = $this->buildLimit($model, $limit, $offset);
        $model = $this->buildOrderBy($model, $orderBy);
        $model = $model->get();

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Function getAllByFilters
     *
     * @param array $filters
     * @param array $relationship
     * @param array $orderBy
     * @return \Illuminate\Database\Eloquent\Collection | null
     */
    public function getAllByFilters($filters = [], $relationship = [], $orderBy = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $this->buildRelationShip($model, $relationship);
        $model = $this->buildOrderBy($model, $orderBy);
        $model = $model->get();

        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Function paginateByFilters
     *
     * @param array $filters
     * @param int $pageSize
     * @param array $relationship
     * @param array $orderBy
     * @return \Illuminate\Pagination\LengthAwarePaginator | null
     */
    public function paginateByFilters($filters = [], $pageSize = 10, $relationship = [], $orderBy = [])
    {
        $this->applyCriteria();
        $this->applyScope();

        $model = $this->model;
        $model = $this->buildQuery($model, $filters);
        $model = $this->buildRelationShip($model, $relationship);
        $model = $this->buildOrderBy($model, $orderBy);
        $model = $model->paginate($pageSize);

        $this->resetModel();

        return $this->parserResult($model);
    }


    /*
     * Private
     */
    /**
     * Function buildOrderBy
     *
     * @param $model
     * @param array $orderBy
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function buildOrderBy($model, $orderBy = [])
    {
        if (!empty($orderBy)) {
            foreach ($orderBy as $column => $direction) {
                $model = $model->orderBy($column, $direction);
            }
        }

        return $model;
    }

    /**
     * Function buildLimit
     *
     * @param $model
     * @param int $limit
     * @param int $offset
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function buildLimit($model, $limit = 10, $offset = 0)
    {
        return $model->limit($limit)->offset($offset);
    }

    /**
     * Function buildRelationShip
     *
     * @param $model
     * @param array $relationship
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function buildRelationShip($model, $relationship = [])
    {
        if (!empty($relationship)) {
            $model = $model->with($relationship);
        }

        return $model;
    }

    /**
     * Function isValidKey
     *
     * @param $array
     * @param $key
     * @return bool
     */
    private function isValidKey($array, $key)
    {
        return array_key_exists($key, $array) && !is_null($array[$key]);
    }
}
