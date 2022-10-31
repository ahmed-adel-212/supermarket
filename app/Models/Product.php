<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'id' => 'int',
        'category_id' => 'int',
        'offer_id' => 'int',
        'price' => 'double',
        'recommended' => 'boolean',
        'offer_price' => 'double',
    ];
    
    protected $appends = [
        'offer_price'
    ];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (!empty($value) && file_exists(public_path($value))) ? url($value) : 'http://via.placeholder.com/200x200?text=No+Image',
        );
    }

    public function offerPrice(): Attribute
    {
        return Attribute::make(
            get: function() {
                if (!$this->offer_id || !$this->offer->is_available) {
                    return 0;
                }

                if ($this->offer->offer_type === 'buy-get') {
                    return round($this->offer->offer_price, 2);
                }

                // offer is discount type
                if ($this->offer->discount_type === 'value') {
                    return round($this->price - $this->offer->offer_price, 2);
                }

                // percentage
                return round($this->price - ($this->price * ($this->offer->offer_price *0.01)), 2);
            },
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }
}
