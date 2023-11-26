<?php

namespace App\Http\Controllers;

use App\Events\sent;
use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\PlaceOrderRequest;

class OrderController extends Controller
{
    /**
     * Place a new order.
     */
    public function placeOrder(PlaceOrderRequest $request)
    {
        // Authorization check using Gate
        Gate::authorize('placeOrder', Order::class);

        $order = Order::create([
            'pharmacy_id' => auth()->user()->id,
        ]);

        foreach ($request->input('items') as $item) {
            Orderitem::create([
                'order_id' => $order->id,
                'medicine_id' => $item['medicine_id'],
                'quantity_requested' => $item['quantity'],
            ]);
        }

        return response()->json(['message' => 'Order placed successfully']);
    }

    /**
     * View orders for the authenticated pharmacy user.
     */
    public function viewOrders()
    {
        // Authorization check using Gate
        Gate::authorize('viewOrders', Order::class);

        $orders = Order::where('pharmacy_id', auth()->user()->id)->get();
        return response()->json(['orders' => $orders]);
    }

    /**
     * View all orders from the warehouse perspective.
     */
    public function viewAllOrders()
    {
        // Authorization check using Gate
        Gate::authorize('viewWarehouseOrders', Order::class);

        $orders = Order::all();
        return response()->json(['orders' => $orders]);
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus($orderId, $status)
    {
        // Authorization check using Gate
        Gate::authorize('updateOrderStatus', Order::class);
        $order = Order::findOrFail($orderId);
        if($status === 'sent'){
            event(new sent($order));
        }

        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();

        return response()->json(['message' => 'Order status updated']);
    }

    /**
     * Update the billing status of an order.
     */
    public function updateBillingStatus($orderId, $billingstatus)
    {
        // Authorization check using Gate
        Gate::authorize('updateBillingStatus', Order::class);

        $order = Order::findOrFail($orderId);
        $order->billingstatus = $billingstatus;
        $order->save();

        return response()->json(['message' => 'Payment status updated']);
    }
}
