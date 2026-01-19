@extends('admin.layouts.app')

@section('title')
    Orders
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">
                    Orders ({{ $orders->total() }})
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    จัดการรายการสั่งซื้อ
                </p>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="mb-6 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <form action="{{ route('admin.orders.index') }}" method="GET"
                class="flex flex-wrap items-center justify-between gap-4">



                <!-- Per Page -->
                <div class="flex items-center gap-2">
                    <label for="per_page" class="text-sm font-medium text-slate-600">Show:</label>
                    <select name="per_page" id="per_page" onchange="this.form.submit()"
                        class="rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Card -->
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-left text-slate-600">
                            <th class="px-6 py-3 font-medium">Order ID</th>
                            <th class="px-6 py-3 font-medium">Customer</th>
                            <th class="px-6 py-3 font-medium">Products</th>
                            <th class="px-6 py-3 font-medium">Qty</th>
                            <th class="px-6 py-3 font-medium">Total</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium">Delivered At</th>
                            <th class="px-6 py-3 font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($orders as $order)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="px-6 py-4 text-slate-700">#{{ $order->id }}</td>
                                            <td class="px-6 py-4 font-medium text-slate-800">
                                                {{ $order->user->name ?? 'Unknown' }}
                                                <div class="text-xs text-slate-500">{{ $order->user->email ?? '' }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-col gap-1 max-h-32 overflow-y-auto">
                                                    @foreach($order->products as $product)
                                                        <div class="flex items-center gap-2">
                                                            <img src="{{ asset($product->thumbnail) }}"
                                                                class="h-8 w-8 rounded object-cover border border-slate-200" alt="">
                                                            <span class="text-sm text-slate-600" title="{{ $product->name }}">
                                                                {{ \Illuminate\Support\Str::limit($product->name, 30) }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500">{{ $order->qty }}</td>
                                            <td class="px-6 py-4 text-slate-500">{{ number_format($order->total, 2) }}</td>
                                            <td class="px-6 py-4">
                                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST"
                                                    class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="status" onchange="this.form.submit()"
                                                        class="rounded-lg border-slate-200 text-sm focus:ring-blue-500 focus:border-blue-500 py-1 pl-2 pr-8 shadow-sm 
                                                                                                                                                                                        {{ $order->status === 'delivered' ? 'bg-green-50 text-green-700 border-green-200' :
                            ($order->status === 'cancelled' ? 'bg-red-50 text-red-700 border-red-200' :
                                ($order->status === 'shipped' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-white')) }}">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                            Processing</option>
                                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped
                                                        </option>
                                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                                            Delivered</option>
                                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                            Cancelled</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500">
                                                {{ $order->getRawOriginal('delivered_at') ? \Carbon\Carbon::parse($order->getRawOriginal('delivered_at'))->format('d/m/Y H:i') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-slate-500">
                                                {{ $order->created_at }}
                                            </td>
                                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection