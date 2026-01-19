@extends('admin.layouts.app')

@section('title')
Edit Brand
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">
                แก้ไขแบรนด์สินค้า
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                แก้ไขรายละเอียดแบรนด์สินค้าที่เลือก
            </p>
        </div>

        <a href="#"
            class="inline-flex items-center gap-2 rounded-xl
                  bg-blue-600 px-4 py-2 text-sm font-medium text-white
                  hover:bg-blue-700 transition shadow">
            <i class="fas fa-plus"></i>
            เพิ่มแบรนด์สินค้า
        </a>
    </div>

    <!-- Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">

        <form action="{{ route('admin.brands.update', $brand->slug) }}" class="space-y-6" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Brand Name -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    ชื่อแบรนด์สินค้า <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $brand->name) }}"
                    placeholder="กรอกชื่อแบรนด์สินค้า"
                    class="w-full border border-slate-300 rounded-xl px-4 py-3
        text-slate-700 placeholder-slate-400
        focus:outline-none focus:ring-2
        @error('name')
            border-red-500 focus:ring-red-500 focus:border-red-500
        @else
            border-slate-300 focus:ring-blue-500 focus:border-blue-500
        @enderror
    ">


                <!-- Error (mockup) -->
                @error('name')
                <p class="mt-1 text-sm text-red-600">
                    ชื่อแบรนด์สินค้านี้ถูกใช้ไปแล้ว กรุณาใช้ชื่ออื่น
                </p>
                @enderror

            </div>

            <!-- Brand Logo -->
            <div class="mb-5">
                <label for="logo"
                    class="block text-sm font-medium text-slate-700 mb-1">
                    รูปภาพ<span class="text-red-500">*</span>
                </label>

                <input
                    type="file"
                    name="logo"
                    id="logo"
                    class="block w-full text-sm text-slate-700
               file:mr-4 file:py-2 file:px-4
               file:rounded-xl file:border-0
               file:text-sm file:font-medium
               file:bg-blue-600 file:text-white
               hover:file:bg-blue-700
               rounded-xl border border-slate-300
               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
               @error('logo') border-red-500 focus:ring-red-500 @enderror" />

                @error('logo')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="mt-3">
                <img
                    src="{{ asset($brand->logo) }}" alt="Preview"
                    id="logo_preview"
                    class="h-30 w-30 rounded-xl object-cover border border-slate-200 shadow-sm">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    คำอธิบายแบรนด์สินค้า
                </label>

                <textarea
                    type="text"
                    id="description"
                    name="description"
                    placeholder="กรอกคําอธิบายแบรนด์สินค้า"
                    value="{{ $brand->description }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           text-slate-700 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500">
                {{ $brand->description }}
                </textarea>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3 pt-2">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl
                           bg-blue-600 px-6 py-3 text-sm font-medium text-white
                           hover:bg-blue-700 transition shadow">
                    <i class="fas fa-save"></i>
                    บันทึกการเปลี่ยนแปลง
                </button>

                <a
                    href="{{ route('admin.brands.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl
                           border border-slate-300 px-6 py-3 text-sm font-medium
                           text-slate-700 hover:bg-slate-100 transition">
                    ยกเลิก
                </a>
            </div>

        </form>

    </div>

</div>

@endsection