<?php

describe('Admin layout', function () {
    it('renders the admin dashboard view', function () {
        $response = $this->get('/admin/dashboard');

        $response->assertStatus(200)
            ->assertSee('Dashboard Overview')
            ->assertSee('Admin Panel');
    });

    it('redirects test1 to the named admin dashboard route', function () {
        $response = $this->get('/test1');

        $response->assertRedirect('/admin/dashboard');
    });

    it('redirects test2 to the hardcoded admin dashboard route', function () {
        $response = $this->get('/test2');

        $response->assertRedirect('/admin/dashboard');
    });
});
