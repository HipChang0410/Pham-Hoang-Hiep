<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Schema::hasTable('products')
            ? Product::query()->where('slug', $slug)->where('status', 1)->firstOrFail()
            : null;
        $categories = Schema::hasTable('categories')
            ? Category::query()->where('status', 1)->orderBy('catename')->get()
            : collect();
        $brands = Schema::hasTable('brands')
            ? Brand::query()->where('status', 1)->orderBy('brandname')->get()
            : collect();

        if (! $product) {
            abort(404);
        }

        return view('client.product.show', compact('product', 'categories', 'brands'));
    }

    public function category(string $slug)
    {
        $category = Schema::hasTable('categories')
            ? Category::query()->where('slug', $slug)->where('status', 1)->firstOrFail()
            : null;
        $products = Schema::hasTable('products')
            ? Product::query()
                ->when($category, fn ($query) => $query->where('cateid', $category->id))
                ->where('status', 1)
                ->orderByDesc('id')
                ->paginate(12)
            : collect()->paginate(12);
        $categories = Schema::hasTable('categories')
            ? Category::query()->where('status', 1)->orderBy('catename')->get()
            : collect();
        $brands = Schema::hasTable('brands')
            ? Brand::query()->where('status', 1)->orderBy('brandname')->get()
            : collect();

        if (! $category) {
            abort(404);
        }

        return view('client.product.category', compact('products', 'category', 'categories', 'brands'));
    }

    public function brand(string $slug)
    {
        $brand = Schema::hasTable('brands')
            ? Brand::query()->where('slug', $slug)->where('status', 1)->firstOrFail()
            : null;
        $products = Schema::hasTable('products')
            ? Product::query()
                ->when($brand, fn ($query) => $query->where('brandid', $brand->id))
                ->where('status', 1)
                ->orderByDesc('id')
                ->paginate(12)
            : collect()->paginate(12);
        $categories = Schema::hasTable('categories')
            ? Category::query()->where('status', 1)->orderBy('catename')->get()
            : collect();
        $brands = Schema::hasTable('brands')
            ? Brand::query()->where('status', 1)->orderBy('brandname')->get()
            : collect();

        if (! $brand) {
            abort(404);
        }

        return view('client.product.brand', compact('products', 'brand', 'categories', 'brands'));
    }

    public function search(Request $request)
    {
        $keyword = trim($request->query('q', ''));
        $products = Schema::hasTable('products')
            ? Product::query()
                ->where('status', 1)
                ->where(function ($query) use ($keyword) {
                    $query->where('productname', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%")
                        ->orWhere('slug', 'like', "%{$keyword}%")
                        ->orWhereHas('brand', function ($brandQuery) use ($keyword) {
                            $brandQuery->where('brandname', 'like', "%{$keyword}%");
                        })
                        ->orWhereHas('category', function ($categoryQuery) use ($keyword) {
                            $categoryQuery->where('catename', 'like', "%{$keyword}%");
                        });
                })
                ->orderByDesc('id')
                ->paginate(12)
            : collect()->paginate(12);
        $categories = Schema::hasTable('categories')
            ? Category::query()->where('status', 1)->orderBy('catename')->get()
            : collect();
        $brands = Schema::hasTable('brands')
            ? Brand::query()->where('status', 1)->orderBy('brandname')->get()
            : collect();

        return view('client.product.search', compact('products', 'keyword', 'categories', 'brands'));
    }
}
