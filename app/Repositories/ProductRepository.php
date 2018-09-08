<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Repository entity
     *
     * @var Product
     */
    private $product;

    /**
     * ProductRepository constructor.
     * @param Product $products
     */
    public function __construct(Product $products)
    {
        $this->product = $products;
    }

    /**
     * Gets all imported products
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getImportedProducts()
    {
        return $this->product->all();
    }

    /**
     * Insert multiple products at once
     *
     * @param array $product
     * @return bool
     */
    public function insertBulkProducts(array $product)
    {
        try{
            return $this->product->insert($product);
        }catch (\Exception $e)
        {
            return false;
        }
    }

    /**
     * Update product entity
     *
     * @param array $params
     * @param Product $model
     * @return bool
     */
    public function updateProduct(array $params, Product $model)
    {
        return $model->update($params);
    }
}