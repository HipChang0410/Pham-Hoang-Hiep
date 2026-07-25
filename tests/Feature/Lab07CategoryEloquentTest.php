<?php

use Illuminate\Support\Facades\DB;

describe('Category Eloquent', function () {
    beforeEach(function () {
        $this->artisan('migrate:fresh', ['--seed' => true]);
    });

    it('renders the paginated category list', function () {
        $response = $this->get('/admin/categories');

        $response->assertStatus(200)
            ->assertSee('Danh sách loại sản phẩm');
    });

    it('stores a new category via Eloquent', function () {
        $response = $this->post('/admin/categories', [
            'catename' => 'Category eloquent',
            'slug' => 'category-eloquent',
        ]);

        $response->assertRedirect('/admin/categories');
        expect(DB::table('categories')->where('slug', 'category-eloquent')->exists())->toBeTrue();
    });
});
