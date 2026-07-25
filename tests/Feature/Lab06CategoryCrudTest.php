<?php

use Illuminate\Support\Facades\DB;

describe('Category CRUD', function () {
    beforeEach(function () {
        $this->artisan('migrate:fresh', ['--seed' => true]);
    });

    it('shows the category index page', function () {
        $response = $this->get('/admin/categories');

        $response->assertStatus(200)
            ->assertSee('Danh sách loại sản phẩm');
    });

    it('creates a category and redirects back to the list', function () {
        $response = $this->post('/admin/categories', [
            'catename' => 'Category test',
            'slug' => 'category-test',
        ]);

        $response->assertRedirect('/admin/categories');
        expect(DB::table('categories')->where('slug', 'category-test')->exists())->toBeTrue();
    });
});
