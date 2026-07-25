<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            $title = 'Bài viết '.$i;

            DB::table('posts')->insert([
                'title' => $title,
                'slug' => Str::slug($title).'-'.$i,
                'content' => 'Nội dung bài viết '.$i,
                'image' => 'post-'.$i.'.jpg',
                'status' => 1,
                'user_id' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
