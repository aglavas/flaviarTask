<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * Load relation to model
     *
     * @param $relation
     * @param Model $model
     * @return $this
     */
    public function loadRelation($relation, Model $model)
    {
        return $model->load($relation);
    }
}
