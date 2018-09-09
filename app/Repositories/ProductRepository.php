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
        try {
            return $this->product->insert($product);
        } catch (\Exception $e) {
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

    /**
     * Get all products vendor details ordered by price
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllProductDetails()
    {
        return $this->product->with(['vendors' => function ($query) {
            $query->orderBy('price', 'asc');
        }])->get();
    }

    /**
     * Get product min, max, avg price if possible to calculate (attached to at least two vendors)
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProductStatistics()
    {
        return $this->product->join('product_vendor', 'products.id', '=', 'product_vendor.product_id')
            ->selectRaw('products.*, MIN(product_vendor.price) AS min_price')
            ->selectRaw('products.*, MAX(product_vendor.price) AS max_price')
            ->selectRaw('products.*, AVG(product_vendor.price) AS avg_price')
            ->havingRaw('COUNT(product_vendor.product_id) >= 2')
            ->groupBy('products.id')
            ->orderBy('price', 'desc')
            ->get();
    }

    /**
     * Load relationship on model instance
     *
     * @param $relation
     * @param Product $product
     * @return Product
     */
    public function loadRelation($relation, Product $product)
    {
        return $product->load($relation);
    }
}
