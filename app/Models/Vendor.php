<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Entity table
     *
     * @var string
     */
    protected $table = 'vendors';

    /**
     * Disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Vendor belongs to many products
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_vendor', 'vendor_id', 'product_id')
            ->withPivot(['stock','price']);
    }

    /**
     * Price accessor
     *
     * @param $value
     * @return string
     */
    public function getPriceAttribute($value)
    {
        $price = number_format((float)$this->pivot->price, 2, '.', '');
        return $price;
    }
}
