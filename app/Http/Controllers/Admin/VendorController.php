<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\VendorRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatchVendorRequest;
use App\Models\Vendor;

class VendorController extends Controller
{
    /**
     * Vendor repository property
     *
     * @var VendorRepositoryInterface
     */
    private $vendorRepository;

    /**
     * VendorController constructor.
     * @param VendorRepositoryInterface $vendorRepository
     */
    public function __construct(VendorRepositoryInterface $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    /**
     * Get all vendors
     *
     * @return $this
     */
    public function getVendors()
    {
        $vendors = $this->vendorRepository->getAllVendors();

        return view('admin.vendor.list')->with('vendors', $vendors);
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
}
