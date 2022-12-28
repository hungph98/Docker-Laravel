<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Traits\RepositoryTraits;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\ExampleRepository;
use App\Models\Example;

/**
 * Class ExampleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ExampleRepositoryEloquent extends BaseRepository implements ExampleRepository
{
    use RepositoryTraits;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Example::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function buildQuery($model, $filters)
    {

        if ($this->isValidKey($filters, 'id')) {
            $model = $model->where('id', $filters['id']);
        }

        if ($this->isValidKey($filters, 'name')) {
            $model = $model->where('name', $filters['name']);
        }

        if ($this->isValidKey($filters, 'name_like')) {
            $model = $model->where('name', 'like', "%" . $filters['name_like'] . "%");
        }

        return $model;
    }

    /**
     * Function store
     *
     * @param $values
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|mixed
     */
    public function store($values)
    {
        return $this->create($values);
    }
}
