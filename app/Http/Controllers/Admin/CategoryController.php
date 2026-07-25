<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $list = DB::table('categories')
            ->select('id', 'catename', 'slug', 'image', 'status', 'sort_order')
            ->orderBy('catename')
            ->get();

        return view('admin.categories.index', compact('list'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        DB::table('categories')->insert([
            'catename' => $request->input('catename'),
            'slug' => $request->input('slug'),
            'image' => $request->input('image', 'default.png'),
            'status' => 1,
            'sort_order' => 0,
            'description' => null,
            'created_at' => now(),
            'updated_at' => now(),
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
        DB::table('categories')->where('id', $id)->delete();

        return redirect()->route('admin.categories.index');
    }
}
