<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorPriceResource extends JsonResource
{
    /**
     * Transform VendorPrice resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'vendor' => $this->name,
            'price' => $this->pivot->price
        ];
    }
}
