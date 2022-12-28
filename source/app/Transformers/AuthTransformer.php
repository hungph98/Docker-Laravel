<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Auth;

/**
 * Class AuthTransformer.
 *
 * @package namespace App\Transformers;
 */
class AuthTransformer extends TransformerAbstract
{
    /**
     * Transform the Auth entity.
     *
     * @param \App\Models\Auth $model
     *
     * @return array
     */
    public function transform(Auth $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
