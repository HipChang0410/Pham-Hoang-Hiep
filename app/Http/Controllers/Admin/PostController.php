<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return 'Post index';
    }

    public function create()
    {
        return 'Post create';
    }

    public function store(Request $request)
    {
        return 'Post store';
    }

    public function show(string $id)
    {
        return 'Post show: '.$id;
    }

    public function edit(string $id)
    {
        return 'Post edit: '.$id;
    }

    public function update(Request $request, string $id)
    {
        return 'Post update: '.$id;
    }

    public function destroy(string $id)
    {
        return 'Post destroy: '.$id;
    }
}
