<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ForumCategory;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new ForumCategory();
        $data->title = 'Fashion';
        $data->featured_image = "default-placeholder-".rand(1, 4).".png";
        $data->created_by_id = 1;
        $data->save();

        $data = new ForumCategory();
        $data->title = 'Organization';
        $data->featured_image = "default-placeholder-".rand(1, 4).".png";
        $data->created_by_id = 1;
        $data->save();

        $data = new ForumCategory();
        $data->title = 'Groups';
        $data->featured_image = "default-placeholder-".rand(1, 4).".png";
        $data->created_by_id = 1;
        $data->save();

        $data = new ForumCategory();
        $data->title = 'Marketing';
        $data->featured_image = "default-placeholder-".rand(1, 4).".png";
        $data->created_by_id = 1;
        $data->save();

        $data = new ForumCategory();
        $data->title = 'Campaign';
        $data->featured_image = "default-placeholder-".rand(1, 4).".png";
        $data->created_by_id = 1;
        $data->save();
    }
}
