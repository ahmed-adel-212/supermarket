<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Area extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'id' => 'int',
        'delivery_fees' => 'double',
    ];
}
