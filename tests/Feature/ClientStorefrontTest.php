<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('client home page displays latest products', function () {
    $category = Category::create([
        'catename' => 'Chuột',
        'slug' => 'chuot',
        'status' => 1,
    ]);
    $brand = Brand::create([
        'brandname' => 'Logitech',
        'slug' => 'logitech',
        'status' => 1,
    ]);
    Product::create([
        'productname' => 'Chuột Logitech G102',
        'slug' => 'chuot-logitech-g102',
        'price' => 500000,
        'pricediscount' => 450000,
        'image' => 'demo.png',
        'description' => 'Chuột gaming',
        'status' => 1,
        'brandid' => $brand->id,
        'cateid' => $category->id,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('Sản phẩm mới nhất')
        ->assertSee('Chuột Logitech G102');
});

test('client product detail and search pages work', function () {
    $category = Category::create([
        'catename' => 'Bàn phím',
        'slug' => 'ban-phim',
        'status' => 1,
    ]);
    $brand = Brand::create([
        'brandname' => 'Razer',
        'slug' => 'razer',
        'status' => 1,
    ]);
    Product::create([
        'productname' => 'Bàn phím Razer BlackWidow',
        'slug' => 'ban-phim-razer-blackwidow',
        'price' => 2000000,
        'pricediscount' => 1800000,
        'image' => 'demo.png',
        'description' => 'Bàn phím cơ',
        'status' => 1,
        'brandid' => $brand->id,
        'cateid' => $category->id,
    ]);

    $detailResponse = $this->get('/product/ban-phim-razer-blackwidow');
    $detailResponse->assertStatus(200)
        ->assertSee('Bàn phím Razer BlackWidow');

    $searchResponse = $this->get('/search?q=razer');
    $searchResponse->assertStatus(200)
        ->assertSee('Bàn phím Razer BlackWidow');
});

test('cart can be stored in session and checked out', function () {
    $category = Category::create([
        'catename' => 'Tai nghe',
        'slug' => 'tai-nghe',
        'status' => 1,
    ]);
    $brand = Brand::create([
        'brandname' => 'Sony',
        'slug' => 'sony',
        'status' => 1,
    ]);
    $product = Product::create([
        'productname' => 'Tai nghe Sony WH-1000XM5',
        'slug' => 'tai-nghe-sony-wh-1000xm5',
        'price' => 12000000,
        'pricediscount' => 11000000,
        'image' => 'demo.png',
        'description' => 'Tai nghe chống ồn',
        'status' => 1,
        'brandid' => $brand->id,
        'cateid' => $category->id,
    ]);

    $this->post('/cart/add', [
        'product_id' => $product->id,
        'quantity' => 2,
    ])->assertRedirect();

    $cart = session('cart');

    expect($cart[$product->id]['quantity'])->toBe(2);

    $this->post('/checkout', [
        'fullname' => 'Nguyễn Văn A',
        'phone' => '0123456789',
        'address' => 'Hà Nội',
        'email' => 'a@example.com',
    ])->assertRedirect('/');

    $this->assertDatabaseHas('customers', ['phone' => '0123456789']);
    $this->assertDatabaseHas('orders', ['status' => 'pending']);
    $this->assertDatabaseHas('order_items', ['product_id' => $product->id]);
});
