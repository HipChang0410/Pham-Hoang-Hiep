<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('checkout creates order and clears the cart', function () {
    $category = Category::create([
        'catename' => 'Electronics',
        'slug' => 'electronics',
        'status' => 1,
    ]);
    $brand = Brand::create([
        'brandname' => 'Acme',
        'slug' => 'acme',
        'status' => 1,
    ]);
    $product = Product::create([
        'productname' => 'Laptop',
        'slug' => 'laptop',
        'price' => 1000000,
        'pricediscount' => 900000,
        'image' => 'default.png',
        'description' => 'Great laptop',
        'status' => 1,
        'brandid' => $brand->id,
        'cateid' => $category->id,
    ]);

    session()->put('cart', [
        $product->id => [
            'product_id' => $product->id,
            'product_name' => $product->productname,
            'quantity' => 2,
            'price' => 900000,
        ],
    ]);

    $response = $this->post('/checkout', [
        'fullname' => 'Nguyen Van A',
        'phone' => '0123456789',
        'address' => '123 Test Street',
        'email' => 'a@example.com',
    ]);

    $response->assertRedirect('/');
    $response->assertSessionHas('success', 'Đặt hàng thành công.');

    $customer = Customer::query()->where('email', 'a@example.com')->first();
    expect($customer)->not->toBeNull();
    $order = Order::query()->where('customer_id', $customer->id)->first();
    expect($order)->not->toBeNull();
    expect($order->total_amount)->toEqual(1800000);
    expect($order->status)->toEqual('pending');

    $item = OrderItem::query()->where('order_id', $order->id)->first();
    expect($item)->not->toBeNull();
    expect($item->quantity)->toEqual(2);
    expect($item->price)->toEqual(900000);
    expect(session('cart'))->toBeEmpty();
});

test('admin can view and update order status', function () {
    $category = Category::create([
        'catename' => 'Phones',
        'slug' => 'phones',
        'status' => 1,
    ]);
    $brand = Brand::create([
        'brandname' => 'Beta',
        'slug' => 'beta',
        'status' => 1,
    ]);
    $product = Product::create([
        'productname' => 'Phone',
        'slug' => 'phone',
        'price' => 500000,
        'pricediscount' => 450000,
        'image' => 'default.png',
        'description' => 'Great phone',
        'status' => 1,
        'brandid' => $brand->id,
        'cateid' => $category->id,
    ]);

    $customer = Customer::create([
        'fullname' => 'Jane Doe',
        'phone' => '0987654321',
        'address' => '456 Admin Street',
        'email' => 'jane@example.com',
    ]);

    $order = Order::create([
        'customer_id' => $customer->id,
        'total_amount' => 450000,
        'status' => 'pending',
    ]);

    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => 1,
        'price' => 450000,
    ]);

    $response = $this->get('/admin/orders');

    $response->assertOk();
    $response->assertSee($customer->fullname);
    $response->assertSee('pending');

    $response = $this->patch('/admin/orders/'.$order->id.'/status', [
        'status' => 'processing',
    ]);

    $response->assertRedirect('/admin/orders');
    $this->assertSame('processing', $order->fresh()->status);
});
