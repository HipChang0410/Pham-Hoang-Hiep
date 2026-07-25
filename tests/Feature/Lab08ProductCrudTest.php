<?php

use Illuminate\Support\Facades\DB;

describe('Product CRUD', function () {
    beforeEach(function () {
        $this->artisan('migrate:fresh', ['--seed' => true]);
    });

    it('renders the product index page', function () {
        $response = $this->get('/admin/products');

        $response->assertStatus(200)
            ->assertSee('Danh sách sản phẩm');
    });

    it('stores a new product and redirects to the index', function () {
        $category = DB::table('categories')->first();
        $brand = DB::table('brands')->first();

        $response = $this->post('/admin/products', [
            'productname' => 'Sản phẩm test',
            'slug' => 'san-pham-test',
            'cateid' => $category?->id ?? 1,
            'brandid' => $brand?->id ?? 1,
            'price' => 150000,
            'pricediscount' => 120000,
            'status' => 1,
            'description' => 'Mô tả sản phẩm test',
        ]);

        $response->assertRedirect('/admin/products');
        expect(DB::table('products')->where('slug', 'san-pham-test')->exists())->toBeTrue();
    });
});
