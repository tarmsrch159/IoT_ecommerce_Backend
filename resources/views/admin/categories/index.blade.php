@extends('admin.layouts.app')

@section('title')
Categories
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">
                Categories ({{ $categories->count() }})
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                จัดการประเภทสินค้า
            </p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2
                   text-sm font-medium text-white hover:bg-blue-700 transition shadow">
            <i class="fas fa-plus"></i>
            Add Category
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
                        <th class="px-6 py-3 font-medium">คำอธิบาย</th>
                        <th class="px-6 py-3 font-medium text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    <!-- Row 1 -->
                    @foreach ( $categories as $key => $category )
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-slate-700">{{ $key + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $category->name }}
                        </td>
                       
                        <td class="px-6 py-4 text-slate-500">
                            {{ $category->description }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex gap-2">

                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="rounded-lg bg-yellow-100 px-3 py-1.5
                                           text-yellow-700 hover:bg-yellow-200 transition">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button onclick="deleteItem('{{ $category->id }}')"
                                    class="rounded-lg bg-red-100 px-3 py-1.5
                                           text-red-600 hover:bg-red-200 transition">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <form id="{{$category->id}}"
                                    action="{{route('admin.categories.destroy',$category->id)}}" method="post">
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

    </div>

</div>

@endsection