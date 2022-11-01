<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'email_verified_at',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (!empty($value) && file_exists(public_path($value))) ? url($value) : 'http://via.placeholder.com/200x200?text=No+Image',
        );
    }

    public function isAdmin()
    {
        return $this->type === 'admin';
    }

    public function isCashier()
    {
        return $this->type === 'cashier';
    }

    public function isCustomer()
    {
        return $this->type === 'customer';
    }
    
    /**
     * define favourite items to users relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favourites(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'favourite_product')->as('favourite_product');
    }

    /**
     * add an products to favourites
     *
     * @param product $product
     * @return void
     */
    public function addToFavourites(Product $product)
    {
        if ($product->is_favourite) return;

        $this->favourites()->attach($product);
    }

    /**
     * remove an products from favourites
     *
     * @param products $product
     * @return void
     */
    public function removeFromFavourites(Product $product)
    {
        if (!$product->is_favourite) return;

        $this->favourites()->detach($product);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function points(): HasMany
    {
        return $this->hasMany(PointTransaction::class);
    }
}
