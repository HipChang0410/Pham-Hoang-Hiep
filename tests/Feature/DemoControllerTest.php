<?php

describe('Demo controller', function () {
    it('renders the demo index view', function () {
        $response = $this->get('/demo');

        $response->assertStatus(200);
        $response->assertSee('Lập trình web 2- Laravel – Lab 03');
    });

    it('returns json data for index3', function () {
        $response = $this->get('/demo/index3');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'data' => [
                    'name' => 'Sản phẩm 1',
                    'price' => 240000,
                ],
            ]);
    });

    it('renders the category resource index page', function () {
        $response = $this->get('/admin/category');

        $response->assertStatus(200);
        $response->assertSee('Category index');
    });
});
