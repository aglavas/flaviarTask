<?php

namespace App\Repositories;

use App\Contracts\VendorRepositoryInterface;
use App\Models\Vendor;

class VendorRepository implements VendorRepositoryInterface
{
    /**
     * Repository entity
     *
     * @var Vendor
     */
    private $vendor;

    /**
     * VendorRepository constructor.
     * @param Vendor $vendor
     */
    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Get all vendors
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllVendors()
    {
        return $this->vendor->all();
    }

    /**
     * Update vendor entity
     *
     * @param array $params
     * @param Vendor $model
     * @return bool
     */
    public function updateVendor(array $params, Vendor $model)
    {
        return $model->update($params);
    }
}
