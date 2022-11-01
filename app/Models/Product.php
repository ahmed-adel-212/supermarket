<?php

namespace App\Models;

use App\Traits\Logger;
use Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslations;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;
    use Logger;

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
        'offer_price',
        'is_favourite'
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
                    return round($this->offer->offer_value, 2);
                }

                // offer is discount type
                if ($this->offer->discount_type === 'value') {
                    return round($this->price - $this->offer->offer_value, 2);
                }

                // percentage
                return round($this->price - ($this->price * ($this->offer->offer_value * 0.01)), 2);
            },
        );
    }

    public function isFavourite(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!Auth::check()) {
                    return false;
                }

                return $this->favourites()->where('user_id', Auth::id())->exists();
            },
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function offer(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class)->as('offer_product');
    }

    public function order(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->as('order_product');
    }

    /**
     * define favourite items to users relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favourite_product')->as('favourite_product');
    }
}
