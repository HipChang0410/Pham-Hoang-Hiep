<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class DemoController extends Controller
{
    public function index()
    {
        return view('demoindex');
    }

    public function index2()
    {
        $data = 'Lập trình web 2 - Laravel';

        return view('demoindex2', compact('data'));
    }

    public function index3(): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => [
                'name' => 'Sản phẩm 1',
                'price' => 240000,
            ],
        ]);
    }

    public function index4(string $id)
    {
        $data = 'Lập trình web 2 - Laravel';

        return view('demoindex4', compact('data', 'id'));
    }

    public function index5(?string $id = null)
    {
        dump($id);

        $data = 'Lập trình web 2 - Laravel';

        return view('demoindex5', compact('data', 'id'));
    }

    public function index5WithDd(?string $id = null)
    {
        dd($id);
    }

    public function index6(string $param1, string $param2)
    {
        $data = 'Lập trình web 2 - Laravel';

        return view('demoindex6', compact('data', 'param1', 'param2'));
    }
}
