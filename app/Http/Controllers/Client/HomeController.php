<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Schema::hasTable('categories')
            ? Category::query()->where('status', 1)->orderBy('catename')->get()
            : collect();
        $brands = Schema::hasTable('brands')
            ? Brand::query()->where('status', 1)->orderBy('brandname')->get()
            : collect();
        $latestProducts = Schema::hasTable('products')
            ? Product::query()
                ->where('status', 1)
                ->orderByDesc('id')
                ->limit(8)
                ->get()
            : collect();
        $saleProducts = Schema::hasTable('products')
            ? Product::query()
                ->where('status', 1)
                ->whereNotNull('pricediscount')
                ->where('pricediscount', '<', 'price')
                ->orderByDesc('id')
                ->limit(8)
                ->get()
            : collect();

        return view('client.home.index', compact('categories', 'brands', 'latestProducts', 'saleProducts'));
    }
}
