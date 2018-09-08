<?php

namespace App\Repository;

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
}