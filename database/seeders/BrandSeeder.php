<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $name = 'Thương hiệu '.$i;

            DB::table('brands')->insert([
                'brandname' => $name,
                'slug' => Str::slug($name).'-'.$i,
                'image' => 'brand-'.$i.'.jpg',
                'status' => 1,
                'sort_order' => $i,
                'description' => 'Mô tả cho '.$name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
