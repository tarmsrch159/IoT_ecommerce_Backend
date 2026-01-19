@extends('admin.layouts.app')

@section('title')
Edit category
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">
                แก้ไขประเภทสินค้า
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                แก้ไขรายละเอียดประเภทสินค้าที่เลือก
            </p>
        </div>

        <a href="#"
            class="inline-flex items-center gap-2 rounded-xl
                  bg-blue-600 px-4 py-2 text-sm font-medium text-white
                  hover:bg-blue-700 transition shadow">
            <i class="fas fa-plus"></i>
            เพิ่มประเภทสินค้า
        </a>
    </div>

    <!-- Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">

        <form action="{{ route('admin.categories.update', $category->id) }}" class="space-y-6" method="post">
            @csrf
            @method('PUT')
            <!-- Category Name -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    ชื่อประเภทสินค้า <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $category->name) }}"
                    placeholder="กรอกชื่อประเภทสินค้า"
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
                    ชื่อประเภทสินค้านี้ถูกใช้ไปแล้ว กรุณาใช้ชื่ออื่น
                </p>
                @enderror

            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    คำอธิบายประเภทสินค้า
                </label>

                <textarea
                    type="text"
                    id="description"
                    name="description"
                    placeholder="กรอกคําอธิบายประเภทสินค้า"
                    value="{{ $category->description }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           text-slate-700 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500">
                {{ $category->description }}
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
                    href="{{ route('admin.categories.index') }}"
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