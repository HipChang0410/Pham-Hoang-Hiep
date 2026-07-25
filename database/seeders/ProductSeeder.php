<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $name = 'Sản phẩm '.$i;
            $price = 100000 + ($i * 50000);

            DB::table('products')->insert([
                'productname' => $name,
                'slug' => Str::slug($name).'-'.$i,
                'price' => $price,
                'pricediscount' => $price * 0.9,
                'image' => 'product-'.$i.'.jpg',
                'description' => 'Mô tả cho '.$name,
                'status' => 1,
                'brandid' => rand(1, 10),
                'cateid' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
