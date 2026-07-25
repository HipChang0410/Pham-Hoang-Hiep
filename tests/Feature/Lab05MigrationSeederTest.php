<?php

use Illuminate\Support\Facades\DB;

it('creates the core tables and seeds sample data', function () {
    config([
        'database.default' => 'sqlite',
        'database.connections.sqlite' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ],
    ]);

    $this->artisan('migrate:fresh', ['--seed' => true]);

    expect(DB::table('categories')->count())->toBeGreaterThan(0)
        ->and(DB::table('brands')->count())->toBeGreaterThan(0)
        ->and(DB::table('staff_users')->count())->toBeGreaterThan(0)
        ->and(DB::table('products')->count())->toBeGreaterThan(0)
        ->and(DB::table('posts')->count())->toBeGreaterThan(0);
});
