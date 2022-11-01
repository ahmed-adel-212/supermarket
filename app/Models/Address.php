<?php

namespace App\Models;

use App\Traits\Logger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Logger;

    protected $guarded = [];

    Protected static $creatValidation = [
        'name' => ['required', 'string'],
        'street' => ['nullable', 'string'],
        'building_number' => ['nullable', 'string'],
        'floor_number' => ['nullable', 'string'],
        'landmark' => ['nullable'],
        'area_id' => ['required', 'exists:areas,id'],
        'user_id' => ['exists:users,id'],
    ];

    Protected static $editValidation = [
        'name' => ['required', 'string'],
        'street' => ['nullable', 'string'],
        'building_number' => ['nullable', 'string'],
        'floor_number' => ['nullable', 'string'],
        'landmark' => ['nullable'],
        'area_id' => ['required', 'exists:areas,id'],
        'user_id' => ['exists:users,id'],
    ];

    Protected static $validationMessages = [

    ];


    /**
     * user relation
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * area relation
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
