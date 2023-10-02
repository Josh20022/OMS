<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function setOrder(Request $request)
    {
        $order = Order::where([
            ['user_id', $request->user_id],
            ['type', $request->type],
            ['category', $request->category]
        ])->first();

        if($order) $order->update($request->all()); else Order::create($request->all());
        return response()->json(['status' => true]);
    }
}
