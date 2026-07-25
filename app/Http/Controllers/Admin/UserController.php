<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return 'User index';
    }

    public function create()
    {
        return 'User create';
    }

    public function store(Request $request)
    {
        return 'User store';
    }

    public function show(string $id)
    {
        return 'User show: '.$id;
    }

    public function edit(string $id)
    {
        return 'User edit: '.$id;
    }

    public function update(Request $request, string $id)
    {
        return 'User update: '.$id;
    }

    public function destroy(string $id)
    {
        return 'User destroy: '.$id;
    }
}
