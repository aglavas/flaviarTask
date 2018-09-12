<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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
                'name' => $this->name,
                'products' => ProductsInfoResource::collection($this->products)
            ]
        ];
    }
}
