<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;

class LoyaltyController extends AbstractApiController
{
    public function index()
    {
        return $this->sendResponse([
            'point_values' => LoyaltyPoint::all(),
        ]);
    }
}
