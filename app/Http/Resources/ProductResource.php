<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform Product resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 'success',
            'data' =>[
                'id' => $this->id,
                'product_id' => $this->product_id,
                'name' => $this->name,
                'volume' => $this->volume,
                'abv' => $this->abv,
                'prices' => VendorPriceResource::collection($this->vendors)
            ]
        ];
    }
}
