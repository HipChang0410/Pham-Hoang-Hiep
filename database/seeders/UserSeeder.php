<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('staff_users')->insert([
                'fullname' => 'Người dùng '.$i,
                'username' => 'user'.$i,
                'email' => 'user'.$i.'@example.com',
                'password' => bcrypt('password'.$i),
                'phone' => '09000000'.$i,
                'address' => 'Địa chỉ '.$i,
                'gender' => ($i % 2) + 1,
                'birthday' => now()->subYears(20 + $i)->toDateString(),
                'role' => $i % 2 === 0 ? 2 : 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
