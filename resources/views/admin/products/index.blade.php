@extends('admin.layouts.app')

@section('title')
    Products
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">
                    Product ({{ $products->count() }})
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    จัดการสินค้า
                </p>
            </div>
            <a href="{{ route('admin.products.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2
                                                               text-sm font-medium text-white hover:bg-blue-700 transition shadow">
                <i class="fas fa-plus"></i>
                Add Product
            </a>

        </div>

        <!-- Card -->
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-left text-slate-600">
                            <th class="px-6 py-3 font-medium">#</th>
                            <th class="px-6 py-3 font-medium">ชื่อ</th>
                            <th class="px-6 py-3 font-medium">SKU</th>
                            <th class="px-6 py-3 font-medium">ประเภทสินค้า</th>
                            <th class="px-6 py-3 font-medium">จำนวนสินค้า</th>
                            <th class="px-6 py-3 font-medium">คำอธิบาย</th>
                            <th class="px-6 py-3 font-medium">Image</th>
                            <th class="px-6 py-3 font-medium">สถานะ</th>
                            <th class="px-6 py-3 font-medium text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        <!-- Row 1 -->
                        @foreach ($products as $key => $product)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-700">{{ $products->firstItem() + $key }}</td>
                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $product->name }}
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $product->sku }}
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $product->category->name ?? 'ไม่มีประเภทสินค้า' }}
                                </td>

                                <td class="px-6 py-4 text-slate-500">
                                    @if ($product->qty == 0)
                                        หมดสต็อก
                                    @elseif($product->qty < 5)
                                        <a class="text-red-600 hover:text-red-700 transition">
                                            {{ $product->qty }}
                                        </a>
                                    @else
                                        {{ $product->qty }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    @if ($product->description == null)
                                        ไม่มีคำอธิบาย
                                    @endif
                                    {{ $product->description }}
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}"
                                        class="h-16 w-16 object-cover rounded-lg">
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    @if ($product->status == 'active')
                                        <span class="px-2 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-full">Active</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex gap-2">

                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="rounded-lg bg-yellow-100 px-3 py-1.5
                                                                                                                                   text-yellow-700 hover:bg-yellow-200 transition">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <button onclick="deleteItem('{{ $product->id }}')"
                                            class="rounded-lg bg-red-100 px-3 py-1.5
                                                                                                                                   text-red-600 hover:bg-red-200 transition">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        <form id="{{$product->id}}" action="{{route('admin.products.destroy', $product->id)}}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>
<div class="px-6 py-4 border-t border-slate-200">
    {{ $products->links() }}
</div>
        </div>

    </div>

@endsection