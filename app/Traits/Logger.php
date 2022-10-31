<?php

namespace App\Traits;

use App\Models\Log;
use Auth;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Logger
{
    public function model_logger(): MorphOne
    {
        return $this->morphOne(Log::class, 'model');
    }

    public function log(string $action) {
        $this->model_logger()->create([
            'user_id' => Auth::id() ?? 1,
            'model_type' => self::class,
            'model_id' => $this->id,
            'action' => $action,
        ]);
    }
}