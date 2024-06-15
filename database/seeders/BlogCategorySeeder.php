<?php

namespace Database\Seeders;

use App\Models\BlogCategories;
use Illuminate\Database\Seeder;
use Faker\Factory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for($i = 1; $i < 15; $i++) {

            $data = new BlogCategories();
            $data->title = $faker->text(20);
            $data->description = $faker->text(40);
            $data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->is_featured = rand(0, 1);
            $data->created_by_id = 1;
            $data->save();
        }

    }
}
