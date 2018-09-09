<?php

namespace App\Contracts;

interface VendorRepositoryInterface
{
    /**
     * Gets all vendors
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllVendors();

}