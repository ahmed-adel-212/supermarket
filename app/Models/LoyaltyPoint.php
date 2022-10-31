<?php

namespace App\Models;

use App\Traits\Logger;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoyaltyPoint extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Logger;

    protected $guarded = [];
}
