<?php

namespace App\Contracts;

use App\Models\Vendor;

interface VendorRepositoryInterface
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
}
