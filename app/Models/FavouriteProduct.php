<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FavouriteProduct extends Pivot
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'user_id' => 'int',
        'product_id' => 'int',
    ];
}
