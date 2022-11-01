<?php

namespace App\Models;

use App\Traits\Logger;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslations;

class Category extends Model
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
    ];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (!empty($value) && file_exists(public_path($value))) ? url($value) : 'http://via.placeholder.com/200x200?text=No+Image',
        );
    }

    public function is_parent(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->category_id == null,
        );
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
