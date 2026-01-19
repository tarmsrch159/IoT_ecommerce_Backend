<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OrderResource;
use App\Models\Product;

class OrderController extends Controller
{

    /***
     * Store user orders
     */

    public function storeUserOrders(Request $request)
    {
        $user = $request->user();
        $cartItems = $request->cartItems;

        $order = DB::transaction(function () use ($cartItems, $user) {

            $products = Product::whereIn(
                'id',
                collect($cartItems)->pluck('id')
            )->get()->keyBy('id');

            $totalQty = 0;
            $totalPrice = 0;

            foreach ($cartItems as $item) {
                $product = $products[$item['id']];
                $totalQty += $item['quantity'];
                $totalPrice += $product->price * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'province_id' => $user->province_id,
                'qty' => $totalQty,
                'total' => $totalPrice,
            ]);

            foreach ($cartItems as $item) {
                $product = $products[$item['id']];

                $order->products()->attach($product->id, [
                    'quantity' => $item['quantity'],
                    'price' => $product->price
                ]);
            }

            return $order;
        });

        return response()->json([
            'message' => 'Order created successfully',
            'order' => new OrderResource($order),
            'user' => new UserResource($user),
        ]);
    }



    /**
     * Calculate total (Deprecated but kept for reference if needed)
     */
    public function calculateEachOrderTotal($qty, $price)
    {
        return $price * $qty;
    }
}
