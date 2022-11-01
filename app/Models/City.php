<?php

namespace App\Models;

use App\Traits\Logger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslations;

class City extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;
    use Logger;

    protected $guarded = [];

    public $translatable = ['name'];

    protected $casts = [
        'id' => 'int',
    ];

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class);
    }
}
