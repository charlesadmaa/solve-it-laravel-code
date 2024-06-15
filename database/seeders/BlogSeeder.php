<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\UserInterests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        for($i = 1; $i < 25; $i++) {
            $data = new Blog();
            $data->title = $faker->realTextBetween(12, 20);
            $data->body = $faker->realTextBetween(500, 1000);
            $data->is_featured = rand(0, 1);
            //$data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->featured_image = "default-image.png";
            $data->created_by_id = 1;
            $data->save();
        }


        for($i = 1; $i < 25; $i++) {
            $data = new Blog();
            $data->title = $faker->realTextBetween(12, 20);
            $data->body = $faker->realTextBetween(500, 1000);
            $data->is_featured = rand(0, 1);
            //$data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->featured_image = "default-image.png";
            $data->created_by_id = 1;
            $data->save();
        }


        for($i = 1; $i < 25; $i++) {
            $data = new Blog();
            $data->title = $faker->realTextBetween(12, 20);
            $data->body = $faker->realTextBetween(500, 1000);
            $data->is_featured = rand(0, 1);
            //$data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->featured_image = "default-image.png";
            $data->created_by_id = 1;
            $data->save();
        }


        for($i = 1; $i < 25; $i++) {
            $data = new Blog();
            $data->title = $faker->realTextBetween(12, 20);
            $data->body = $faker->realTextBetween(500, 1000);
            $data->is_featured = rand(0, 1);
            //$data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->featured_image = "default-image.png";
            $data->created_by_id = 1;
            $data->save();
        }


        for($i = 1; $i < 25; $i++) {
            $data = new Blog();
            $data->title = $faker->realTextBetween(12, 20);
            $data->body = $faker->realTextBetween(500, 1000);
            $data->is_featured = rand(0, 1);
            //$data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->featured_image = "default-image.png";
            $data->created_by_id = 1;
            $data->save();
        }


        for($i = 1; $i < 25; $i++) {
            $data = new Blog();
            $data->title = $faker->realTextBetween(12, 20);
            $data->body = $faker->realTextBetween(500, 1000);
            $data->is_featured = rand(0, 1);
            //$data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->featured_image = "default-image.png";
            $data->created_by_id = 1;
            $data->save();
        }


        for($i = 1; $i < 25; $i++) {
            $data = new Blog();
            $data->title = $faker->realTextBetween(12, 20);
            $data->body = $faker->realTextBetween(500, 1000);
            $data->is_featured = rand(0, 1);
            //$data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->featured_image = "default-image.png";
            $data->created_by_id = 1;
            $data->save();
        }


        for($i = 1; $i < 25; $i++) {
            $data = new Blog();
            $data->title = $faker->realTextBetween(12, 20);
            $data->body = $faker->realTextBetween(500, 1000);
            $data->is_featured = rand(0, 1);
            //$data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->featured_image = "default-image.png";
            $data->created_by_id = 1;
            $data->save();
        }

        for($i = 1; $i < 25; $i++) {
            $data = new Blog();
            $data->title = $faker->realTextBetween(12, 20);
            $data->body = $faker->realTextBetween(500, 1000);
            $data->is_featured = rand(0, 1);
            //$data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->featured_image = "default-image.png";
            $data->created_by_id = 1;
            $data->save();
        }


        for($i = 1; $i < 25; $i++) {
            $data = new Blog();
            $data->title = $faker->realTextBetween(12, 20);
            $data->body = $faker->realTextBetween(500, 1000);
            $data->is_featured = rand(0, 1);
            //$data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->featured_image = "default-image.png";
            $data->created_by_id = 1;
            $data->save();
        }
    }
}
