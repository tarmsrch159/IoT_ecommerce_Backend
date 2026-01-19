<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\AddBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.brands.index')->with([
            'brands' => Brand::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddBrandRequest $request)
    {
        //
        if ($request->validated()) {
            $data = $request->validated();
            $data['slug'] = Str::slug($request->name);
            if ($request->hasFile('logo')) {
                $data['logo'] = $this->saveImage($request->file('logo'));
            }
            Brand::create($data);
            return redirect()->route('admin.brands.index')->with([
                'success' => 'เพิ่มแบรนด์สินค้าสำเร็จ'
            ]);
        }
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
    public function edit(Brand $brand)
    {
        //
        return view('admin.brands.edit')->with([
            'brand' => $brand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        //
        if ($request->validated()) {
            $data = $request->validated();
            $data['slug'] = Str::slug($request->name);
            if ($request->hasFile('logo')) {
                
                $this->removeProductImageFromStorage($brand->logo);
                // Save new image
                $data['logo'] = $this->saveImage($request->file('logo'));
            }
            $brand->update($data);
            return redirect()->route('admin.brands.index')->with([
                'success' => 'แก้ไขแบรนด์สินค้าสำเร็จ'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
        $this->removeProductImageFromStorage($brand->logo);
        $brand->delete();
        return redirect()->route('admin.brands.index')->with([
            'success' => 'ลบแบรนด์สินค้าสำเร็จ'
        ]);
        
    }

    /**
     * Upload and save product images
     */
    public function saveImage($file)
    {
        $image_name = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('images/brands', $image_name, 'public');
        return 'storage/images/brands/' . $image_name;
    }

    /**
     * Remove old images from storage
     */
    public function removeProductImageFromStorage($file)
    {
        $path = public_path($file);
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
