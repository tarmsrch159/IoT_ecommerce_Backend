@extends('admin.layouts.app')

@section('title')
Locations
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">
                Locations (3)
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                จัดการสถานที่เก็บสินค้าและจุดจำหน่าย
            </p>
        </div>

        <a href="{{ route('admin.locations.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2
                  text-sm font-medium text-white hover:bg-blue-700 transition shadow">
            <i class="fas fa-map-marker-alt"></i>
            Add Location
        </a>
    </div>

    <!-- Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-600">
                        <th class="px-6 py-3 font-medium">#</th>
                        <th class="px-6 py-3 font-medium">Name</th>
                        <th class="px-6 py-3 font-medium">Type</th>
                        <th class="px-6 py-3 font-medium">Location</th>
                        <th class="px-6 py-3 font-medium">จังหวัด</th>
                        <th class="px-6 py-3 font-medium">อำเภอ</th>
                        <th class="px-6 py-3 font-medium">ตำบล</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @foreach ( $locations as $key => $location )
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-slate-700">{{ $key + 1 }}</td>

                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $location->name }}
                        </td>

                        <td class="px-6 py-4">
                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700">
                                {{ $location->type }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-slate-500">
                            {{ $location->address }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $location->province?->name_th ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $location->district?->name_th ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $location->subdistrict?->name_th ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            @if ($location->status)
                            <span
                                class="inline-flex items-center gap-2 rounded-full
                                       bg-green-100 px-3 py-1 text-xs font-medium
                                       text-green-700">
                                <i class="fas fa-check-circle"></i>
                                Active
                            </span>
                            @else
                            <span
                                class="inline-flex items-center gap-2 rounded-full
                                       bg-red-100 px-3 py-1 text-xs font-medium
                                       text-red-700">
                                <i class="fas fa-times-circle"></i>
                                Inactive
                            </span>
                            @endif
                            
                            
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.locations.edit', $location->id) }}"
                                    class="rounded-lg bg-yellow-100 px-3 py-1.5
                                          text-yellow-700 hover:bg-yellow-200 transition">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button onclick="deleteItem('{{ $location->id }}')"
                                    class="rounded-lg bg-red-100 px-3 py-1.5
                                           text-red-600 hover:bg-red-200 transition">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <form id="{{$location->id}}"
                                    action="{{route('admin.locations.destroy',$location->id)}}" method="post">
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