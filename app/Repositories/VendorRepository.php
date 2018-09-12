<?php

namespace App\Repositories;

use App\Contracts\VendorRepositoryInterface;
use App\Models\Vendor;

class VendorRepository extends BaseRepository implements VendorRepositoryInterface
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

    /**
     * Update related products and product details
     *
     * @param array $params
     * @param Vendor $vendor
     * @param bool $format
     * @return array
     */
    public function updateVendorProducts(array $params, Vendor $vendor, $format = true)
    {
        if ($format) {
            $params = $this->formatParams($params);
        }

        return $vendor->products()->sync($params);
    }

    /**
     * Format parameters to sync method structure
     *
     * @param $params
     * @return array
     */
    protected function formatParams($params)
    {
        $formattedParams = [];

        foreach ($params['productIds'] as $key => $id) {
            $formattedParams[$id] = [
                'stock' => $params['stock'][$id],
                'price' => $params['price'][$id]
            ];
        }

        return $formattedParams;
    }
}
