@extends('admin.layouts.app')

@section('title')
Add new category
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            เพิ่มประเภทสินค้าใหม่
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            กรอกข้อมูลประเภทสินค้าใหม่ด้านล่าง
        </p>
    </div>

    <!-- Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">

        <form action="{{ route('admin.categories.store') }}" class="space-y-6" method="POST">
            @csrf
            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    ชื่อประเภทสินค้า <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="ชื่อประเภทสินค้า"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                           text-slate-700 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500">

                <!-- Error (mockup) -->
                @error('name')
                <p class="mt-1 text-sm text-red-600">
                    ชื่อประเภทสินค้าจำเป็นต้องระบุ
                </p>
                @enderror
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

                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2
                           rounded-xl border border-slate-300 px-6 py-3
                           text-sm font-medium text-slate-700
                           hover:bg-slate-100 transition">
                    ยกเลิก
                </button>
            </div>

        </form>

    </div>

</div>

@endsection