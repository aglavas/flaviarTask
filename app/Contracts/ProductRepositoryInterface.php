<?php

namespace App\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    /**
     * Gets all imported products
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getImportedProducts();

    /**
     * Insert multiple products at once
     *
     * @param array $collection
     * @return bool
     */
    public function insertBulkProducts(array $collection);
}