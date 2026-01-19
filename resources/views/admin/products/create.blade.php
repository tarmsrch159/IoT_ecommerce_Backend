@extends('admin.layouts.app')

@section('title')
    Add new Product
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-6">

        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-slate-800">
                เพิ่มสินค้าใหม่
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                กรอกข้อมูลสินค้าใหม่
            </p>
        </div>

        <!-- Card -->
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">

            <form action="{{ route('admin.products.store') }}" class="space-y-6" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        ชื่อสินค้า <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="name" placeholder="ชื่อสินค้า" class="w-full rounded-xl border border-slate-300 px-4 py-3
                                   text-slate-700 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500">

                    <!-- Error (mockup) -->
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            ชื่อสินค้าจำเป็นต้องระบุ
                        </p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        ราคา <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="price" placeholder="ราคาสินค้า" class="w-full rounded-xl border border-slate-300 px-4 py-3
                                   text-slate-700 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500">

                    <!-- Error (mockup) -->
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">
                            ราคาจำเป็นต้องระบุ
                        </p>
                    @enderror
                </div>

                <!-- qty -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        จำนวนสินค้า <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="qty" placeholder="จำนวนสินค้า" class="w-full rounded-xl border border-slate-300 px-4 py-3
                                   text-slate-700 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500">

                    <!-- Error (mockup) -->
                    @error('qty')
                        <p class="mt-1 text-sm text-red-600">
                            จำนวนสินค้าจำเป็นต้องระบุ7
                        </p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-5">
                    <label for="category_id" class="block mb-1 text-sm font-medium text-slate-700">
                        Category <span class="text-red-500">*</span>
                    </label>

                    <select name="category_id" id="category_id" class="w-full rounded-xl bg-white border border-slate-300 px-4 py-2.5 text-sm text-slate-700
                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                       @error('category_id') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">

                        <option value="" disabled selected>
                            Choose a category
                        </option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

               

                <!-- Thumbnail -->
                <div class="mb-5">
                    <label for="thumbnail" class="block text-sm font-medium text-slate-700 mb-1">
                        รูปภาพ<span class="text-red-500">*</span>
                    </label>

                    <input type="file" name="thumbnail" id="thumbnail" class="block w-full text-sm text-slate-700
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-xl file:border-0
                       file:text-sm file:font-medium
                       file:bg-blue-600 file:text-white
                       hover:file:bg-blue-700
                       rounded-xl border border-slate-300
                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                       @error('thumbnail') border-red-500 focus:ring-red-500 @enderror" />

                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mt-3">
                    <img src="#" alt="Preview" id="thumbnail_preview"
                        class="hidden h-30 w-30 rounded-xl object-cover border border-slate-200 shadow-sm">
                </div>


                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        คำอธิบาย <span class="text-red-500">*</span>
                    </label>

                    <textarea type="text" name="description" placeholder="คำอธิบายสินค้า" class="w-full rounded-xl border border-slate-300 px-4 py-3
                                   text-slate-700 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500">

                        </textarea>

                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center justify-center gap-2
                                   rounded-xl bg-blue-600 px-6 py-3
                                   text-sm font-medium text-white
                                   hover:bg-blue-700 transition shadow">
                        <i class="fas fa-save"></i>
                        บันทึก
                    </button>

                    <a href="{{ route('admin.products.index') }}" type="button" class="inline-flex items-center justify-center gap-2
                                   rounded-xl border border-slate-300 px-6 py-3
                                   text-sm font-medium text-slate-700
                                   hover:bg-slate-100 transition">
                        ยกเลิก
                    </a>
                </div>

            </form>

        </div>

    </div>

@endsection