<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    public $guarded = [];

    protected $timestamps = false;

    protected $casts = [
        'id' => 'int',
        'order_id' => 'int',
        'product_id' => 'int',
        'offer_id' => 'int',
        'quantity' => 'int',
        'price' => 'double',
        'offer_price' => 'double',
    ];
}
