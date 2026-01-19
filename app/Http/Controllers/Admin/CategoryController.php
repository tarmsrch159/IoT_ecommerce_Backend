<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.categories.index')->with([
            'categories' => Category::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCategoryRequest $request)
    {
        //
        $data = $request->validated();

        // generate slug รองรับภาษาไทย
        $data['slug'] = $this->generateSlug($data['name']);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'เพิ่มประเภทสินค้าสำเร็จ');
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
    public function edit(Category $category)
    {
        //
        return view('admin.categories.edit')->with([
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
        if ($request->validated()) {
            $data = $request->validated();
            $category->update($data);
            return redirect()->route('admin.categories.index')->with([
                'success' => 'แก้ไขประเภทสินค้าสำเร็จ'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with([
            'success' => 'ลบประเภทสินค้าสำเร็จ'
        ]);
    }

    private function generateSlug(string $name): string
    {
        $slug = Str::slug($name);

        // ถ้าเป็นภาษาไทย slug จะว่าง
        if ($slug === '') {
            $slug = 'category-' . time();
        }

        // กัน slug ซ้ำ
        $original = $slug;
        $count = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}
