@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            แก้ไขสินค้า
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            แก้ไขรายละเอียดสินค้า
        </p>
    </div>

    <!-- Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">

        <form
            action="{{ route('admin.products.update', $product->id) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6">

            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    ชื่อสินค้า <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                    placeholder="ชื่อสินค้า"
                    class="w-full rounded-xl border px-4 py-3 text-slate-700
                    focus:outline-none focus:ring-2
                    @error('name')
                        border-red-500 focus:ring-red-500
                    @else
                        border-slate-300 focus:ring-blue-500
                    @enderror">

                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    ราคา <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    name="price"
                    value="{{ old('price', $product->price) }}"
                    placeholder="ราคาสินค้า"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Qty -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    จำนวนสินค้า <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    name="qty"
                    value="{{ old('qty', $product->qty) }}"
                    placeholder="จำนวนสินค้า"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('qty')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block mb-1 text-sm font-medium text-slate-700">
                    Category <span class="text-red-500">*</span>
                </label>

                <select
                    name="category_id"
                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <option disabled>Choose a category</option>

                    @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(old('category_id', $product->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>

                @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

          

            <!-- Thumbnail -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    รูปภาพ
                </label>

                <input
                    type="file"
                    name="thumbnail"
                    id="thumbnail"
                    class="block w-full text-sm text-slate-700
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-xl file:border-0
                           file:bg-blue-600 file:text-white
                           hover:file:bg-blue-700
                           rounded-xl border border-slate-300
                            @error('thumbnail') border-red-500 focus:ring-red-500 @enderror">

                @error('thumbnail')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Preview -->
            <div>
                <img
                    src="{{ asset($product->thumbnail) }}"
                    alt="Preview"
                    id="thumbnail_preview"
                    class="h-32 w-32 rounded-xl object-cover border border-slate-200 shadow-sm">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    คำอธิบาย
                </label>

                <textarea
                    name="description"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-medium text-slate-700">
                    สถานะสินค้า
                </label>

                <!-- In Stock -->
                <label class="flex items-center gap-3 cursor-pointer">
                    <input
                        type="radio"
                        name="status"
                        value="1"
                        @checked($product->status == true)
                    class="h-4 w-4 text-blue-600 border-slate-300
                    focus:ring-2 focus:ring-blue-500">
                    <span class="text-sm text-slate-700">
                        In Stock
                    </span>
                </label>

                <!-- Out of Stock -->
                <label class="flex items-center gap-3 cursor-pointer">
                    <input
                        type="radio"
                        name="status"
                        value="0"
                        @checked($product->status == false)
                    class="h-4 w-4 text-blue-600 border-slate-300
                    focus:ring-2 focus:ring-blue-500">
                    <span class="text-sm text-slate-700">
                        Out of Stock
                    </span>
                </label>
            </div>


            <!-- Actions -->
            <div class="flex gap-3 pt-2">
                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm text-white
                           hover:bg-blue-700 shadow">
                    บันทึกการเปลี่ยนแปลง
                </button>

                <a
                    href="{{ route('admin.products.index') }}"
                    class="rounded-xl border border-slate-300 px-6 py-3
                           text-sm text-slate-700 hover:bg-slate-100">
                    ยกเลิก
                </a>
            </div>

        </form>

    </div>
</div>
@endsection