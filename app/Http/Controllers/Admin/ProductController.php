<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ProductRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostProductRequest;
use App\Models\Product;
use App\Services\XlsParser;
use Illuminate\Http\Request;

class ProductController extends Controller
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
     * Get imported products
     *
     * @return $this
     */
    public function getProducts()
    {
        $products = $this->productRepository->getImportedProducts();

        return view('admin.product.import')->with('products', $products);
    }

    /**
     * Import products
     *
     * @param XlsParser $parser
     * @param PostProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postProducts(XlsParser $parser, PostProductRequest $request)
    {
        $parsedArray = $parser->parse($request->file('file'));

        $result = $this->productRepository->insertBulkProducts($parsedArray);

        if($result)
        {
            return redirect()->back()->with('success', __('Data imported successfully'));
        }

        return redirect()->back()->with('error', __('Error while importing data, possible duplicates detected'));
    }
}