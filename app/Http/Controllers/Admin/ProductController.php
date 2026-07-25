<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with(['category', 'brand'])
            ->orderBy('productname')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::query()->select('id', 'catename')->orderBy('catename')->get();
        $brands = Brand::query()->select('id', 'brandname')->orderBy('brandname')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        $imageName = null;

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $imageName = Str::slug($request->input('productname')).'-'.time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('products', $imageName, 'public');
        }

        $product = Product::create([
            'productname' => $request->input('productname'),
            'slug' => $request->input('slug'),
            'price' => $request->input('price'),
            'pricediscount' => $request->input('pricediscount', 0),
            'image' => $imageName ?? 'default.png',
            'description' => $request->input('description'),
            'status' => $request->input('status', 1),
            'brandid' => $request->input('brandid'),
            'cateid' => $request->input('cateid'),
        ]);

        if ($request->hasFile('imgs')) {
            $time = time();
            foreach ($request->file('imgs') as $index => $file) {
                $imageFileName = $product->id.'_'.$time.'_'.($index + 1).'.'.$file->getClientOriginalExtension();
                $file->storeAs('products', $imageFileName, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageFileName,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công');
    }

    public function show(string $id)
    {
        return 'Product show: '.$id;
    }

    public function edit(string $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::query()->select('id', 'catename')->orderBy('catename')->get();
        $brands = Brand::query()->select('id', 'brandname')->orderBy('brandname')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(ProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $imageName = $product->image;

        if ($request->hasFile('img')) {
            if ($product->image && $product->image !== 'default.png') {
                Storage::disk('public')->delete('products/'.$product->image);
            }

            $file = $request->file('img');
            $imageName = Str::slug($request->input('productname')).'-'.time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('products', $imageName, 'public');
        }

        $product->update([
            'productname' => $request->input('productname'),
            'slug' => $request->input('slug'),
            'price' => $request->input('price'),
            'pricediscount' => $request->input('pricediscount', 0),
            'image' => $imageName ?? 'default.png',
            'description' => $request->input('description'),
            'status' => $request->input('status', 1),
            'brandid' => $request->input('brandid'),
            'cateid' => $request->input('cateid'),
        ]);

        if ($request->hasFile('imgs')) {
            $time = time();
            foreach ($request->file('imgs') as $index => $file) {
                $imageFileName = $product->id.'_'.$time.'_'.($index + 1).'.'.$file->getClientOriginalExtension();
                $file->storeAs('products', $imageFileName, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageFileName,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function destroy(string $id)
    {
        Product::destroy($id);

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    }

    public function test1()
    {
        return redirect()->route('admin.home');
    }

    public function test2()
    {
        return redirect('/admin/dashboard');
    }
}
