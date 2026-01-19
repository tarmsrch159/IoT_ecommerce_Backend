<?php

namespace App\Http\Controllers\Admin;

use App\Models\District;
use App\Models\Location;
use App\Models\Province;
use App\Models\Subdistrict;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.locations.index')->with([
            'locations' => Location::latest()->get(),
            'provinces' => Province::where('id', '!=', 0)->orderBy('name_th')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $provinces = Province::orderBy('name_th')->get();
        return view('admin.locations.create')->with([
            'locations' => Location::latest()->get(),
            'provinces' => $provinces,

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        //
        $data = $request->validated();
        $data['status'] = $request->has('is_active') ? true : false;

        Location::create($data);

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'เพิ่มสถานที่เรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //

        return view('admin.locations.edit')->with([
            'location' => $location,
            'provinces' => Province::orderBy('name_th')->get(),
            'districts' => District::where('province_id', $location->province_id)->orderBy('name_th')->get(),
            'subdistricts' => Subdistrict::where('district_id', $location->district_id)->orderBy('name_th')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        //
        $data = $request->validated();
        $data['status'] = $request->has('is_active') ? true : false;

        $location->update($data);

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'แก้ไขสถานที่เรียบร้อยแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        //
        $location->delete();
        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'ลบสถานที่เรียบร้อยแล้ว');
    }

    public function getDistricts($provinceId)
    {
        return response()->json(
            District::where('province_id', $provinceId)
                ->orderBy('name_th')
                ->get(['id', 'name_th'])
        );
    }

    public function getSubdistricts($districtId)
    {
        return response()->json(
            Subdistrict::where('district_id', $districtId)
                ->orderBy('name_th')
                ->get(['subdistrict_id', 'name_th', 'zipcode'])
        );
    }
}
