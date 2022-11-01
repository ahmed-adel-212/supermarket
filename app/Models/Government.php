<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Government extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['name'];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function areas(): HasManyThrough
    {
        return $this->hasManyThrough(Area::class, City::class);
    }
}
