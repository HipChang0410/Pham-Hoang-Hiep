<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return 'Product index';
    }

    public function create()
    {
        return 'Product create';
    }

    public function store(Request $request)
    {
        return 'Product store';
    }

    public function show(string $id)
    {
        return 'Product show: '.$id;
    }

    public function edit(string $id)
    {
        return 'Product edit: '.$id;
    }

    public function update(Request $request, string $id)
    {
        return 'Product update: '.$id;
    }

    public function destroy(string $id)
    {
        return 'Product destroy: '.$id;
    }
}
