<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        $imageName = null;

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $imageName = Str::slug($request->input('brandname')).'-'.time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('brands', $imageName, 'public');
        }

        Brand::create([
            'brandname' => $request->input('brandname'),
            'slug' => $request->input('slug'),
            'image' => $imageName ?? 'default.png',
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
        $imageName = $brand->image;

        if ($request->hasFile('img')) {
            if ($brand->image && $brand->image !== 'default.png') {
                Storage::disk('public')->delete('brands/'.$brand->image);
            }

            $file = $request->file('img');
            $imageName = Str::slug($request->input('brandname')).'-'.time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('brands', $imageName, 'public');
        }

        $brand->update([
            'brandname' => $request->input('brandname'),
            'slug' => $request->input('slug'),
            'image' => $imageName ?? 'default.png',
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
