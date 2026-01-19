<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $orders = Order::with(['user', 'products'])
            ->when($search, function ($query, $search) {
                $query->whereHas('products', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $originalStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        if ($request->status === 'delivered' && is_null($order->delivered_at)) {
            $order->delivered_at = Carbon::now();
        } else {
            // If status is changed back from delivered, we clear delivered_at
            if ($order->delivered_at && $request->status !== 'delivered') {
                $order->delivered_at = null;
            }
        }
        $order->save();

        // Stock Management Logic
        $reducedStatuses = ['shipped', 'delivered'];
        $wasReduced = in_array($originalStatus, $reducedStatuses);
        $isReduced = in_array($request->status, $reducedStatuses);

        if (!$wasReduced && $isReduced) {
            // Decrease Stock
            foreach ($order->products as $product) {
                $product->decrement('qty', $product->pivot->quantity);
            }
        } elseif ($wasReduced && !$isReduced) {
            // Increase Stock (Restore)
            foreach ($order->products as $product) {
                $product->increment('qty', $product->pivot->quantity);
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully.');
    }
}
