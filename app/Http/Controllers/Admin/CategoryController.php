<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function trash()
    {
        $list = Category::onlyTrashed()
            ->select('id', 'catename', 'slug', 'image', 'status', 'sort_order')
            ->orderBy('catename')
            ->paginate(10);

        return view('admin.categories.trash', compact('list'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        $imageName = null;

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $imageName = Str::slug($request->input('catename')).'-'.time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('categories', $imageName, 'public');
        }

        Category::create([
            'catename' => $request->input('catename'),
            'slug' => $request->input('slug'),
            'image' => $imageName ?? 'default.png',
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
        $imageName = $category->image;

        if ($request->hasFile('img')) {
            if ($category->image && $category->image !== 'default.png') {
                Storage::disk('public')->delete('categories/'.$category->image);
            }

            $file = $request->file('img');
            $imageName = Str::slug($request->input('catename')).'-'.time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('categories', $imageName, 'public');
        }

        $category->update([
            'catename' => $request->input('catename'),
            'slug' => $request->input('slug'),
            'image' => $imageName ?? 'default.png',
            'status' => $request->input('status', 1),
            'sort_order' => $category->sort_order,
            'description' => $category->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật loại sản phẩm thành công');
    }

    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa loại sản phẩm thành công');
    }

    public function restore(string $id)
    {
        Category::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.categories.trash')->with('success', 'Khôi phục thành công');
    }

    public function forceDelete(string $id)
    {
        Category::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.categories.trash')->with('success', 'Xóa vĩnh viễn thành công');
    }
}
