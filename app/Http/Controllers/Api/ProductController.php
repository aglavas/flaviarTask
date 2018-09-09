<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController
{
    /**
     * Product repository property
     *
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Return product vendor's price
     *
     * @param Product $product
     * @return ProductResource
     */
    public function getProductPrice(Product $product)
    {
        $productVendors = $this->productRepository->loadRelation('vendors', $product);

        return ProductResource::make($productVendors);
    }
}
