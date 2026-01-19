@extends('admin.layouts.app')

@section('title', 'Edit Location')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            แก้ไขสถานที่เก็บสินค้า
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            แก้ไขข้อมูลสถานที่ เช่น ร้านค้า คลังสินค้า หรือบูธ
        </p>
    </div>

    <!-- Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-8">

        <form
            method="POST"
            action="{{ route('admin.locations.update', $location->id) }}"
            class="space-y-6">

            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    ชื่อสถานที่ <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $location->name) }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3"
                    placeholder="เช่น Bangkok Main Warehouse">
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    ประเภทสถานที่ <span class="text-red-500">*</span>
                </label>
                <select
                    name="type"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    <option value="">เลือกประเภท</option>
                    <option value="store" @selected(old('type', $location->type) == 'store')>
                        Store (ร้านค้า)
                    </option>
                    <option value="warehouse" @selected(old('type', $location->type) == 'warehouse')>
                        Warehouse (คลังสินค้า)
                    </option>
                    <option value="booth" @selected(old('type', $location->type) == 'booth')>
                        Booth (บูธ)
                    </option>
                </select>
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    ที่อยู่
                </label>
                <textarea
                    name="address"
                    rows="3"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3"
                    placeholder="ที่อยู่โดยละเอียด">{{ old('address', $location->address) }}</textarea>
            </div>

            <!-- Province / District / Subdistrict -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Province -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        จังหวัด <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="province_id"
                        id="province"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">
                        <option value="">เลือกจังหวัด</option>
                        @foreach ($provinces as $province)
                        <option
                            value="{{ $province->id }}"
                            @selected($province->id == $location->province_id)>
                            {{ $province->name_th }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- District -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        อำเภอ / เขต <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="district_id"
                        id="district"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">
                        @foreach ($districts as $district)
                        <option
                            value="{{ $district->id }}"
                            @selected($district->id == $location->district_id)>
                            {{ $district->name_th }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Subdistrict -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        ตำบล <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="subdistrict_id"
                        id="subdistrict"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3">
                        @foreach ($subdistricts as $sub)
                        <option
                            value="{{ $sub->subdistrict_id }}"
                            data-zipcode="{{ $sub->zipcode }}"
                            @selected($sub->subdistrict_id == $location->subdistrict_id)>
                            {{ $sub->name_th }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Zipcode -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    รหัสไปรษณีย์
                </label>
                <input
                    type="text"
                    id="zipcode"
                    name="postcode"
                    value="{{ old('postcode', $location->postcode) }}"
                    readonly
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-slate-100">
            </div>

            <!-- Status -->
            <div class="flex items-center gap-3">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old('is_active', $location->status))
                    class="h-5 w-5 rounded border-slate-300 text-blue-600">
                <span class="text-sm text-slate-700">
                    เปิดใช้งานสถานที่
                </span>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3 pt-4">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl
                           bg-blue-600 px-6 py-3 text-sm font-medium
                           text-white hover:bg-blue-700 transition shadow">
                    <i class="fas fa-save"></i>
                    บันทึกการเปลี่ยนแปลง
                </button>

                <a href="{{ route('admin.locations.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl
                          border border-slate-300 px-6 py-3
                          text-sm font-medium text-slate-700
                          hover:bg-slate-100 transition">
                    ยกเลิก
                </a>
            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const province = document.getElementById('province');
        const district = document.getElementById('district');
        const subdistrict = document.getElementById('subdistrict');
        const zipcode = document.getElementById('zipcode');

        province.addEventListener('change', async () => {
            district.innerHTML = '<option value="">เลือกอำเภอ</option>';
            subdistrict.innerHTML = '<option value="">เลือกตำบล</option>';
            district.disabled = true;
            subdistrict.disabled = true;
            zipcode.value = '';

            if (!province.value) return;

            const res = await fetch(`/locations/districts/${province.value}`);
            const data = await res.json();

            data.forEach(d => {
                district.innerHTML += `<option value="${d.id}">${d.name_th}</option>`;
            });

            district.disabled = false;
        });

        district.addEventListener('change', async () => {
            subdistrict.innerHTML = '<option value="">เลือกตำบล</option>';
            subdistrict.disabled = true;
            zipcode.value = '';

            if (!district.value) return;

            const res = await fetch(`/locations/subdistricts/${district.value}`);
            const data = await res.json();

            data.forEach(s => {
                subdistrict.innerHTML += `
                <option value="${s.subdistrict_id}" data-zipcode="${s.zipcode}">
                    ${s.name_th}
                </option>`;
            });

            subdistrict.disabled = false;
        });

        subdistrict.addEventListener('change', () => {
            const option = subdistrict.selectedOptions[0];
            zipcode.value = option?.dataset.zipcode ?? '';
        });

    });
</script>
@endsection
