<?php

namespace App\Models;

use App\Traits\Logger;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslations;

class Offer extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;
    use Logger;

    protected $guarded = [];

    public $translatable = ['title', 'description'];

    protected $appends = ['is_available'];

    protected $casts = [
        'date_from' => 'datetime:Y-m-d',
        'date_to' => 'datetime:Y-m-d',
        'main' => 'bool',
        'quantity' => 'int',
        'offer_value' => 'double',
        'get_quantity' => 'int',
        'id' => 'int',
    ];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (!empty($value) && file_exists(public_path($value))) ? url($value) : 'http://via.placeholder.com/200x200?text=No+Image',
        );
    }

    public function isAvailable(): Attribute
    {
        $today = now();
        $dateFrom = $this->date_from;
        $dateTo = $this->date_to;

        return Attribute::make(
            get: fn () => $today->gte($dateFrom) && $today->lte($dateTo),
        );
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->as('order_product');
    }
}
