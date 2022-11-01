<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyPoint;
use App\Models\PointTransaction;
use Illuminate\Http\Request;

class LoyaltyController extends AbstractApiController
{
    public function index()
    {
        return $this->sendResponse([
            'point_values' => LoyaltyPoint::orderBy('points', 'asc')->get(),
        ]);
    }

    public function history()
    {
        return $this->sendResponse([
            'history' => PointTransaction::where('user_id', auth()->id())->get(),
        ]);
    }

    public function screen()
    {
       $gaindPoints = auth()->user()->points()->where('status', 'gained')->sum('points');
       $usedPoints = auth()->user()->points()->where('status', 'used')->orWhere('status', 'pending')->sum('points');
       $user_points = abs($gaindPoints - $usedPoints);
       
       $point_values = LoyaltyPoint::orderBy('points', 'asc')->get();

       $history = PointTransaction::where('user_id', auth()->id())->get();

       return $this->sendResponse(compact('user_points', 'point_values', 'history'));
    }
}
