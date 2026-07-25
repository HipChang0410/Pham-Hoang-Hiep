<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('guests can view the login page', function () {
    $response = $this->get('/admin/login');

    $response->assertStatus(200)
        ->assertSee('Đăng nhập');
});

test('guests are redirected to the login page when they visit the admin dashboard', function () {
    User::create([
        'fullname' => 'Admin User',
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('secret123'),
        'role' => 1,
        'status' => 1,
    ]);

    $response = $this->get('/admin/dashboard');

    $response->assertRedirect('/admin/login');
});

test('users can login with valid credentials and remember me', function () {
    $user = User::create([
        'fullname' => 'Admin User',
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('secret123'),
        'role' => 1,
        'status' => 1,
    ]);

    $response = $this->post('/admin/login', [
        'username' => 'admin',
        'password' => 'secret123',
        'remember' => true,
    ]);

    $response->assertRedirect('/admin/dashboard');
    $this->assertAuthenticatedAs($user);
});

test('authenticated users can change their password', function () {
    $user = User::create([
        'fullname' => 'Password User',
        'username' => 'passworduser',
        'email' => 'password@example.com',
        'password' => Hash::make('oldpassword'),
        'role' => 1,
        'status' => 1,
    ]);

    $this->actingAs($user);

    $response = $this->post('/admin/change-password', [
        'current_password' => 'oldpassword',
        'new_password' => 'newpassword123',
        'new_password_confirmation' => 'newpassword123',
    ]);

    $response->assertRedirect();
    $user->refresh();
    expect(Hash::check('newpassword123', $user->password))->toBeTrue();
});

test('users can request a new password by email', function () {
    $user = User::create([
        'fullname' => 'Forgot Password User',
        'username' => 'forgot',
        'email' => 'forgot@example.com',
        'password' => Hash::make('oldpassword'),
        'role' => 2,
        'status' => 1,
    ]);

    Mail::fake();

    $response = $this->post('/admin/forgotpass', [
        'email' => $user->email,
    ]);

    $response->assertRedirect();
    $user->refresh();
    expect($user->password)->not->toBeEmpty();
});

test('staff users cannot access create routes for admin-only resources', function () {
    $user = User::create([
        'fullname' => 'Staff User',
        'username' => 'staff',
        'email' => 'staff@example.com',
        'password' => Hash::make('password'),
        'role' => 2,
        'status' => 1,
    ]);

    $this->actingAs($user);

    $response = $this->get('/admin/categories/create');

    $response->assertStatus(403);
});
