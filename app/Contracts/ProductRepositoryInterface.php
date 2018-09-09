<?php

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Update product entity
     *
     * @param array $params
     * @param Product $product
     * @return mixed
     */
    public function updateProduct(array $params, Product $product);

    /**
     * Get all products with vendor details
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllProductDetails();

    /**
     * Get product min, max, avg price if possible to calculate (attached to at least two vendors)
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProductStatistics();

    /**
     * Load relationship on model instance
     *
     * @param $relation
     * @param Product $product
     * @return mixed
     */
    public function loadRelation($relation, Product $product);
}
