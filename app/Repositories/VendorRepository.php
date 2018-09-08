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

}