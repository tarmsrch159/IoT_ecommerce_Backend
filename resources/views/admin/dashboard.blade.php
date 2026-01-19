@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-8">

        <!-- Page Title -->
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">Dashboard</h1>
            <p class="text-sm text-slate-500 mt-1">
                ภาพรวมร้านขายอุปกรณ์ IoT
            </p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Total Sales -->
            <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">ยอดขายเดือนนี้</p>
                <p class="mt-2 text-3xl font-semibold text-slate-800">฿{{ $totalPrice }}</p>
                <p class="mt-1 text-sm text-green-600">+12% จากเดือนที่แล้ว</p>
            </div>

            <!-- Orders -->
            <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">ออเดอร์ทั้งหมด</p>
                <p class="mt-2 text-3xl font-semibold text-slate-800">{{ $monthOrders }} </p>
                <p class="mt-1 text-sm text-slate-500">เดือนนี้</p>
            </div>

            <!-- Products -->
            <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">จำนวนสินค้า</p>
                <p class="mt-2 text-3xl font-semibold text-slate-800">{{ $totalProducts }}</p>
                <p class="mt-1 text-sm text-slate-500">SKU</p>
            </div>

            <!-- Low Stock -->
            <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">สินค้าใกล้หมด</p>
                <p class="mt-2 text-3xl font-semibold text-red-500">{{ $lowStockProducts->count() }}</p>
                <p class="mt-1 text-sm text-red-500">ต้องเติมสต็อก</p>
            </div>

        </div>

        <!-- Order Status -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500 mb-3">Pending Orders</p>
                <p class="text-2xl font-semibold text-yellow-500">{{ $pendingOrders }}</p>
            </div>

            <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500 mb-3">Completed Orders</p>
                <p class="text-2xl font-semibold text-green-600">{{ $deliveredOrders }}</p>
            </div>

            <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500 mb-3">Cancelled Orders</p>
                <p class="text-2xl font-semibold text-red-500">{{ $cancelledOrders }}</p>
            </div>

        </div>

        <!-- Best Seller & Low Stock -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Best Seller -->
            <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    สินค้า IoT ขายดี
                </h2>

                <ul class="space-y-3">
                    @foreach ($bestSellingProducts as $product)
                        <li class="flex justify-between text-sm">
                            <span class="text-slate-700">{{ $product->name }}</span>
                            <span class="font-medium">{{ $product->total_sold }} ชิ้น</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Low Stock -->
            <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">
                    สินค้าใกล้หมดสต็อก
                </h2>

                <ul class="space-y-3">
                    @foreach ($lowStockProducts as $productLowStock)
                        <li class="flex justify-between text-sm">
                            <span class="text-slate-700">{{ $productLowStock->name }}</span>
                            <span class="text-red-500 font-medium">เหลือ {{ $productLowStock->qty }}</span>
                        </li>
                    @endforeach

                </ul>
            </div>

        </div>

    </div>
@endsection