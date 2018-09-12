<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\ProductRepositoryInterface;
use App\Contracts\VendorRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatchVendorProductsRequest;
use App\Http\Requests\PatchVendorRequest;
use App\Http\Resources\VendorProductsResource;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Vendor repository property
     *
     * @var VendorRepositoryInterface
     */
    private $vendorRepository;

    /**
     * Product repository property
     *
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * VendorController constructor.
     * @param VendorRepositoryInterface $vendorRepository
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        VendorRepositoryInterface $vendorRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->vendorRepository = $vendorRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Get all vendors
     *
     * @return $this
     */
    public function getVendors()
    {
        $vendors = $this->vendorRepository->getAllVendors();

        $products = $this->productRepository->getAllProducts(['id', 'name']);

        return view('admin.vendor.list')
            ->with('vendors', $vendors)
            ->with('products', $products);
    }

    /**
     * Edit vendor information
     *
     * @param Vendor $vendor
     * @param PatchVendorRequest $request
     * @return $this
     */
    public function patchVendor(Vendor $vendor, PatchVendorRequest $request)
    {
        $result = $this->vendorRepository->updateVendor($request->only(['name']), $vendor);

        if ($result) {
            return response()->json([
                'message' => 'Product is updated successfully.'
            ])->setStatusCode(200);
        }

        return response()->json([
            'message' => 'Error while updating vendor.'
        ])->setStatusCode(500);
    }

    /**
     * Get products that belongs to vendor
     *
     * @param Vendor $vendor
     * @param Request $request
     * @return VendorProductsResource
     */
    public function getVendorProducts(Vendor $vendor, Request $request)
    {
        try {
            $vendorInstance = $vendor->findOrFail($request->route('vendorId'));
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Vendor not found.'
            ])->setStatusCode(404);
        }

        $vendorProducts = $this->vendorRepository->loadRelation('products', $vendorInstance);

        return VendorProductsResource::make($vendorProducts);
    }


    /**
     * Update vendors related products
     *
     * @param Vendor $vendor
     * @param PatchVendorProductsRequest $request
     * @return $this
     */
    public function patchVendorProducts(Vendor $vendor, PatchVendorProductsRequest $request)
    {
        try {
            $vendorInstance = $vendor->findOrFail($request->route('vendorId'));
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Vendor not found.'
            ])->setStatusCode(404);
        }

        $result = $this->vendorRepository->updateVendorProducts($request->input(), $vendorInstance);

        if ($result) {
            return response()->json([
                'message' => 'Product details are updated successfully.'
            ])->setStatusCode(200);
        }

        return response()->json([
            'message' => 'Error while updating product details.'
        ])->setStatusCode(500);
    }
}
