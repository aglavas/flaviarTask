<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * Load relationship on model instance
     *
     * @param $relation
     * @param Model $product
     * @return mixed
     */
    public function loadRelation($relation, Model $product);
}
