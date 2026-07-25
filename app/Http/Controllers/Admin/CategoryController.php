<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return 'Category index';
    }

    public function create()
    {
        return 'Category create';
    }

    public function store(Request $request)
    {
        return 'Category store';
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
        return 'Category destroy: '.$id;
    }
}
