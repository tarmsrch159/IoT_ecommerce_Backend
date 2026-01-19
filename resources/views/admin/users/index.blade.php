@extends('admin.layouts.app')

@section('title')
    Users
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-slate-800">
                    Users ({{ $users->total() }})
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    จัดการผู้ใช้งาน
                </p>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="mb-6 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <form action="{{ route('admin.users.index') }}" method="GET"
                class="flex flex-wrap items-center justify-between gap-4">
                <!-- Search -->
                <div class="relative flex-1 max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full rounded-lg border-slate-200 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Search name or email...">
                </div>

                <!-- Per Page -->
                <div class="flex items-center gap-2">
                    <label for="per_page" class="text-sm font-medium text-slate-600">Show:</label>
                    <select name="per_page" id="per_page" onchange="this.form.submit()"
                        class="rounded-lg border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Card -->
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-left text-slate-600">
                            <th class="px-6 py-3 font-medium">User ID</th>
                            <th class="px-6 py-3 font-medium">Name</th>
                            <th class="px-6 py-3 font-medium">Email</th>
                            <th class="px-6 py-3 font-medium">Registered Date</th>
                            <th class="px-6 py-3 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($users as $key => $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-700">{{ $users->firstItem() + $key }}</td>
                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="javascript:void(0);" onclick="deleteItem('{{ $user->id }}')"
                                        class="rounded-lg bg-red-100 px-3 py-1.5 text-red-600 hover:bg-red-200 transition">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form id="{{$user->id}}" action="{{ route('admin.users.destroy', $user->id) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection