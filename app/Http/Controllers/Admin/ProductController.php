<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\File;
use App\Services\SupabaseStorageService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.products.index')->with([
            'products' => Product::latest()->paginate(4),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('admin.products.create')->with([
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddProductRequest $request,  SupabaseStorageService $storage)
    {
        //
        if ($request->validated()) {
            $data = $request->validated();
            // $data['thumbnail'] = $this->saveImage($request->file('thumbnail'));
            $data['thumbnail'] = $storage->upload(
                $request->file('thumbnail'),
                'products',
                'images/products'
            );


            $data['sku'] = $this->generateSku(
                $request->category_id,
            );
            $data['slug'] = Str::slug($request->name);
            Product::create($data);
            return redirect()->route('admin.products.index')->with([
                'success' => 'Product has been added successfully'
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
    public function edit(Product $product)
    {
        //
        return view('admin.products.edit')->with([
            'product' => $product,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product, SupabaseStorageService $storage)
    {
        //
        if ($request->validated()) {
            $data = $request->validated();
            if ($request->has('thumbnail')) {
                //remove the old thumbnail
                // $this->removeProductImageFromStorage($product->thumbnail);
                $storage->delete($product->thumbnail);
                //store the new thumbnail
                $data['thumbnail'] = $storage->upload(
                    $request->file('thumbnail'),
                    'products',
                    'images/products'
                );
                // $data['thumbnail'] = $this->saveImage($request->file('thumbnail'));
            }

            $data['slug'] = Str::slug($request->name);
            $data['sku'] = $this->generateSku(
                $request->category_id,
            );
            $data['status'] = $request->status;
            $product->update($data);

            return redirect()->route('admin.products.index')->with([
                'success' => 'แก้ไขสินค้าสำเร็จ'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, SupabaseStorageService $storage)
    {
        //
        // $this->removeProductImageFromStorage($product->thumbnail);
        $storage->delete($product->thumbnail);
        $product->delete();
        return redirect()->route('admin.products.index')->with([
            'success' => 'ลบสินค้าสำเร็จ'
        ]);
    }

    /**
     * Upload and save product images
     */
    public function saveImage($file)
    {
        $image_name = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('images/products', $image_name, 'public');
        return 'storage/images/products/' . $image_name;
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

    private function generateSku(int $categoryId,): string
    {
        $categoryCode = strtoupper(
            substr(
                Str::slug(Category::find($categoryId)->name, ''),
                0,
                3
            )
        );



        // กันกรณีชื่อสั้น
        $categoryCode = str_pad($categoryCode, 3, 'X');

        do {
            $sku = "{$categoryCode}-" . strtoupper(Str::random(6));
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }
}
