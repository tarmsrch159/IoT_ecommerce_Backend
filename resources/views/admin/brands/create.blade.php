@extends('admin.layouts.app')

@section('title')
Add new Brand
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            เพิ่มแบรนด์สินค้าใหม่
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            กรอกข้อมูลแบรนด์สินค้าใหม่
        </p>
    </div>

    <!-- Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">

        <form action="{{ route('admin.brands.store') }}" class="space-y-6" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    ชื่อแบรนด์สินค้า <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="ชื่อแบรนด์สินค้า"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           text-slate-700 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500">

                <!-- Error (mockup) -->
                @error('name')
                <p class="mt-1 text-sm text-red-600">
                    ชื่อแบรนด์สินค้าจำเป็นต้องระบุ
                </p>
                @enderror
            </div>
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
                    src="#"
                    alt="Preview"
                    id="logo_preview"
                    class="hidden h-30 w-30 rounded-xl object-cover border border-slate-200 shadow-sm">
            </div>


            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    คำอธิบาย <span class="text-red-500">*</span>
                </label>

                <textarea
                    type="text"
                    name="description"
                    placeholder="คำอธิบายประเภทสินค้า"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           text-slate-700 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500">

                </textarea>

            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2
                           rounded-xl bg-blue-600 px-6 py-3
                           text-sm font-medium text-white
                           hover:bg-blue-700 transition shadow">
                    <i class="fas fa-save"></i>
                    บันทึก
                </button>

                <a href="{{ route('admin.brands.index') }}"
                    type="button"
                    class="inline-flex items-center justify-center gap-2
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