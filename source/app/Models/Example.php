<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Example.
 *
 * @package namespace App\Models;
 */
class Example extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'example';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
}
