<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return 'Brand index';
    }

    public function create()
    {
        return 'Brand create';
    }

    public function store(Request $request)
    {
        return 'Brand store';
    }

    public function show(string $id)
    {
        return 'Brand show: '.$id;
    }

    public function edit(string $id)
    {
        return 'Brand edit: '.$id;
    }

    public function update(Request $request, string $id)
    {
        return 'Brand update: '.$id;
    }

    public function destroy(string $id)
    {
        return 'Brand destroy: '.$id;
    }
}
