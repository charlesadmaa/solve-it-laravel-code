<?php

namespace Database\Seeders;

use App\Models\CategoryBlog;
use Illuminate\Database\Seeder;

class CategoryBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i < 240; $i++) {
            $data = new CategoryBlog();
            $data->blog_id =  rand(1, 240);
            $data->category_id = rand(1, 14);
            $data->save();
        }
    }
}
