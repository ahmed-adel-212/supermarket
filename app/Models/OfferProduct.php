<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

use function PHPSTORM_META\map;

class OfferProduct extends Pivot
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'offer_id' => 'int',
        'product_id' => 'int',
    ];
}
