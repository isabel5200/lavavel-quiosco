<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    // Get orders
    public function index()
    {
        return new OrderCollection(Order::with('user')->with('products')->where('status', 0)->get());
    }

    // Save an order
    public function store(Request $request)
    {
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->total = $request->total;
        $order->save();

        $id = $order->id;

        $products = $request->products;

        $product_order = [];

        foreach ($products as $product) {
            $product_order[] = [
                'order_id' => $id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        OrderProduct::insert($product_order);

        return [
            'message' => 'Your order was placed successfully'
        ];
    }

    public function show(Order $order)
    {
        //
    }

    // Update order (status)
    public function update(Request $request, Order $order)
    {
        $order->status = 1;
        $order->save();

        return [
            'order' => $order
        ];
    }

    public function destroy(Order $order)
    {
        //
    }
}
