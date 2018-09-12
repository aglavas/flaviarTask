<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ProductRepositoryInterface;
use App\Contracts\VendorRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatchProductRequest;
use App\Http\Requests\PostProductRequest;
use App\Http\Requests\PostProductVendorsRequest;
use App\Models\Product;
use App\Services\XlsParser;
use App\Transformers\ProductDetailsTransformer;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;

class ProductController extends Controller
{
    /**
     * Product repository property
     *
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Vendor repository property
     *
     * @var VendorRepositoryInterface
     */
    private $vendorRepository;

    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     * @param VendorRepositoryInterface $vendorRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        VendorRepositoryInterface $vendorRepository
    ) {
        $this->productRepository = $productRepository;
        $this->vendorRepository = $vendorRepository;
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
        try {
            $parsedArray = $parser->parse($request->file('file'));
        } catch (ReaderException $exception) {
            return redirect()->back()->with('error', __('Error while importing data, possible corrupted data.'));
        }

        $result = $this->productRepository->insertBulkProducts($parsedArray);

        if ($result) {
            return redirect()->back()->with('success', __('Data imported successfully'));
        }

        return redirect()->back()->with('error', __('Error while importing data, possible duplicates detected'));
    }


    /**
     * Edit product information
     *
     * @param Product $product
     * @param PatchProductRequest $request
     * @return $this
     */
    public function patchProduct(Product $product, PatchProductRequest $request)
    {
        $result = $this->productRepository->updateProduct($request->only(['name', 'volume', 'abv']), $product);

        if ($result) {
            return response()->json([
                'message' => 'Product is updated successfully.'
            ])->setStatusCode(200);
        }

        return response()->json([
            'message' => 'Error while updating product.'
        ])->setStatusCode(500);
    }

    /**
     * Return product details view with related data
     *
     * @param Product $product
     * @return $this
     */
    public function getProductVendors(Product $product)
    {
        $vendors = $this->vendorRepository->getAllVendors();

        return view('admin.product.details')
            ->with('product', $product)
            ->with('vendors', $vendors);
    }

    /**
     * Connect vendor and product with additional data
     *
     * @param Product $product
     * @param PostProductVendorsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postProductVendors(Product $product, PostProductVendorsRequest $request)
    {
        $product->vendors()->attach($request->post('vendor_id'), [
            'stock' => $request->post('stock'),
            'price' => $request->post('price')
        ]);

        return redirect()->back()->with('success', __('Vendor and product details saved successfully'));
    }

    /**
     * Get all products details with statistic informations
     *
     * @param ProductDetailsTransformer $transformer
     * @return $this
     */
    public function getProductDetails(ProductDetailsTransformer $transformer)
    {
        $productDetails = $this->productRepository->getAllProductDetails();

        $productStatistics = $this->productRepository->getProductStatistics();

        $transformedCollection = $transformer->transform($productDetails, $productStatistics);

        return view('admin.product.details.list')
            ->with('productDetails', $transformedCollection);
    }
}
