<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ExampleRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface ExampleRepository extends RepositoryInterface
{
    public function store($values);
}
