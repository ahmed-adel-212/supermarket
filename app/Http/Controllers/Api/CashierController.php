<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PointTransaction;
use DB;
use Illuminate\Http\Request;

class CashierController extends AbstractApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse([
            'orders' => Order::with(['products', 'customer'])->whereRaw('Date(created_at) >= CURDATE()')->paginate(),
        ]);
    }

    public function accept(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status != 'pending') {
            return $this->sendError(__('general.accept_forbidden'), 400);
        }

        $order->update(['status' => 'in-progress']);
        
        $order->refresh();

        return $this->sendResponse(compact('order'), __('general.Order has been accepted'));
    }

    public function reject(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status != 'in-progress') {
            return $this->sendError(__('general.reject_forbidden'), 400);
        }

        $order->update(['status' => 'rejected']);
        
        $order->refresh();

        // return points used to user
        if ($order->points) {
            $pointTrans = PointTransaction::where('order_id', $order->id)->where('status', 'pending')->first();
            $pointTrans->status = 'gained';
            $pointTrans->save();
        }

        return $this->sendResponse(compact('order'), __('general.Order has been rejected'));
    }

    public function complete(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status != 'in-progress') {
            return $this->sendError(__('general.complete_forbidden'), 400);
        }

        $order->update(['status' => 'completed']);
        
        $order->refresh();

        // get points used to user
        if ($order->points) {
            $pointTrans = PointTransaction::where('order_id', $order->id)->where('status', 'pending')->first();
            $pointTrans->status = 'used';
            $pointTrans->save();
        }

        // give user new points
        PointTransaction::create([
            'order_id' => $order->id,
            'status' => 'gained',
            'user_id' => $order->user_id,
            'points' => $order->total,
        ]);

        return $this->sendResponse(compact('order'), __('general.Order has been completeed'));
    }
}
