<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $list = Category::query()
            ->select('id', 'catename', 'slug', 'image', 'status', 'sort_order')
            ->orderBy('catename')
            ->paginate(10);

        return view('admin.categories.index', compact('list'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create([
            'catename' => $request->input('catename'),
            'slug' => $request->input('slug'),
            'image' => $request->input('image', 'default.png'),
            'status' => $request->input('status', 1),
            'sort_order' => 0,
            'description' => null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm loại sản phẩm thành công');
    }

    public function show(string $id)
    {
        return 'Category show: '.$id;
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'catename' => $request->input('catename'),
            'slug' => $request->input('slug'),
            'image' => $request->input('image', $category->image ?? 'default.png'),
            'status' => $request->input('status', 1),
            'sort_order' => $category->sort_order,
            'description' => $category->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật loại sản phẩm thành công');
    }

    public function destroy(string $id)
    {
        Category::destroy($id);

        return redirect()->route('admin.categories.index')->with('success', 'Xóa loại sản phẩm thành công');
    }
}
