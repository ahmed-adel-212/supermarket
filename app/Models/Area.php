<?php

namespace App\Models;

use App\Traits\Logger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Area extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;
    use Logger;

    protected $guarded = [];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'id' => 'int',
        'delivery_fees' => 'double',
    ];

    public function City(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
