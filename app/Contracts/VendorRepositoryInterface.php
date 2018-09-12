<?php

namespace App\Contracts;

use App\Models\Vendor;

interface VendorRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Gets all vendors
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllVendors();

    /**
     * Update vendor entity
     *
     * @param array $params
     * @param Vendor $vendor
     * @return mixed
     */
    public function updateVendor(array $params, Vendor $vendor);


    /**
     * Update related products and product details
     *
     * @param array $params
     * @param Vendor $vendor
     * @return mixed
     */
    public function updateVendorProducts(array $params, Vendor $vendor);
}
