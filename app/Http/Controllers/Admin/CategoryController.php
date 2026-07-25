<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        Category::create([
            'catename' => $request->input('catename'),
            'slug' => $request->input('slug'),
            'image' => $request->input('image', 'default.png'),
            'status' => 1,
            'sort_order' => 0,
            'description' => null,
        ]);

        return redirect()->route('admin.categories.index');
    }

    public function show(string $id)
    {
        return 'Category show: '.$id;
    }

    public function edit(string $id)
    {
        return 'Category edit: '.$id;
    }

    public function update(Request $request, string $id)
    {
        return 'Category update: '.$id;
    }

    public function destroy(string $id)
    {
        Category::destroy($id);

        return redirect()->route('admin.categories.index');
    }
}
