<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->artisan('migrate:fresh', ['--seed' => true]);
    Storage::fake('public');
});

describe('Lab 10 image upload', function () {
    it('stores a brand image when creating a brand', function () {
        $response = $this->post('/admin/brands', [
            'brandname' => 'Brand test',
            'slug' => 'brand-test',
            'status' => 1,
            'img' => UploadedFile::fake()->create('brand.png', 200, 'image/png'),
        ]);

        $response->assertRedirect('/admin/brands');
        $brand = Brand::where('slug', 'brand-test')->firstOrFail();
        expect($brand->image)->not->toBeNull();
        Storage::disk('public')->assertExists('brands/'.$brand->image);
    });

    it('stores a product with main and secondary images', function () {
        $category = Category::firstOrFail();
        $brand = Brand::firstOrFail();

        $response = $this->post('/admin/products', [
            'productname' => 'Sản phẩm ảnh',
            'slug' => 'san-pham-anh',
            'cateid' => $category->id,
            'brandid' => $brand->id,
            'price' => 120000,
            'pricediscount' => 100000,
            'status' => 1,
            'description' => 'Mô tả',
            'img' => UploadedFile::fake()->create('product-main.png', 200, 'image/png'),
            'imgs' => [
                UploadedFile::fake()->create('product-1.png', 200, 'image/png'),
                UploadedFile::fake()->create('product-2.png', 200, 'image/png'),
            ],
        ]);

        $response->assertRedirect('/admin/products');
        $product = Product::where('slug', 'san-pham-anh')->firstOrFail();
        expect($product->image)->not->toBeNull();
        expect($product->images)->toHaveCount(2);
        Storage::disk('public')->assertExists('products/'.$product->image);
    });
});
