<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;

class ProductDetailsTransformer
{
    /**
     * Statistic information property
     * @var array
     */
    private $priceStatistics;

    /**
     * Merges statistic information into product details collection
     *
     * @param Collection $productDetails
     * @param Collection $additionalInformation
     * @return Collection
     */
    public function transform(Collection $productDetails, Collection $additionalInformation)
    {
        $productDetails->each(function ($product) use($additionalInformation){

            $additionalInformation->each(function ($productAdditional) use($product){

                if($product->product_id == $productAdditional->product_id)
                {
                    $this->priceStatistics = [
                        'min' => $productAdditional->min_price,
                        'max' => $productAdditional->max_price,
                        'avg' => $productAdditional->avg_price,
                    ];

                    return false;
                }
            });

            if($this->priceStatistics != null)
            {
                $product->min = $this->priceStatistics['min'];
                $product->max = $this->priceStatistics['max'];
                $product->avg = $this->priceStatistics['avg'];
            }

            $this->priceStatistics = null;
        });

        return $productDetails;
    }
}
