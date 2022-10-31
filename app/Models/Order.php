<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'address_id' => 'int',
        'points' => 'int',
        'subtotal' => 'double',
        'total' => 'double',
        'taxes' => 'double',
        'delivery_fees' => 'double',
        'points_paid' => 'double',
        'offer_value' => 'double',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->as('order_product');
    }
}
