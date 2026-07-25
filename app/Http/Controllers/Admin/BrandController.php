<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::query()->orderBy('brandname')->paginate(10);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
    {
        Brand::create([
            'brandname' => $request->input('brandname'),
            'slug' => $request->input('slug'),
            'image' => $request->input('image', 'default.png'),
            'status' => $request->input('status', 1),
            'sort_order' => 0,
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Thêm thương hiệu thành công');
    }

    public function show(string $id)
    {
        return 'Brand show: '.$id;
    }

    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->update([
            'brandname' => $request->input('brandname'),
            'slug' => $request->input('slug'),
            'image' => $request->input('image', $brand->image ?? 'default.png'),
            'status' => $request->input('status', 1),
            'sort_order' => $brand->sort_order,
            'description' => $request->input('description'),
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Cập nhật thương hiệu thành công');
    }

    public function destroy(string $id)
    {
        Brand::destroy($id);

        return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công');
    }
}
