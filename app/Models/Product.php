<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abv', 'product_id', 'volume', 'title',
    ];

    /**
     * Entity table
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Route model binding override
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'product_id';
    }

    /**
     * Product belongs to many vendors
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'product_vendor', 'product_id', 'vendor_id')
            ->withPivot(['stock','price']);
    }
}
