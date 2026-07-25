<?php

use Illuminate\Support\Facades\DB;

describe('Lab 09 validation', function () {
    beforeEach(function () {
        $this->artisan('migrate:fresh', ['--seed' => true]);
    });

    it('rejects invalid category input on create', function () {
        $response = $this->from('/admin/categories/create')->post('/admin/categories', [
            'catename' => 'ab',
            'slug' => 'bad slug',
            'status' => 2,
        ]);

        $response->assertRedirect('/admin/categories/create')
            ->assertSessionHasErrors(['catename', 'slug', 'status']);

        expect(DB::table('categories')->where('slug', 'bad-slug')->exists())->toBeFalse();
    });

    it('rejects invalid product input on create', function () {
        $category = DB::table('categories')->first();
        $brand = DB::table('brands')->first();

        $response = $this->from('/admin/products/create')->post('/admin/products', [
            'productname' => 'ab',
            'slug' => 'bad slug',
            'cateid' => $category?->id ?? 1,
            'brandid' => $brand?->id ?? 1,
            'price' => 10000000,
            'pricediscount' => 20000000,
            'status' => 2,
            'description' => 'abc@123',
        ]);

        $response->assertRedirect('/admin/products/create')
            ->assertSessionHasErrors(['productname', 'slug', 'price', 'pricediscount', 'status', 'description']);
    });
});
