<?php

namespace Database\Seeders;

use App\Models\BlogComment;
use Illuminate\Database\Seeder;
use Faker\Factory;

class BlogCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();


        for($i = 1; $i < 25; $i++) {

            $data = new BlogComment();
            $data->blog_id = $i;
            $data->user_id = rand(1, 30);
            $data->comment = $faker->realTextBetween(20, 60);
            $data->save();

        }

        for($i = 1; $i < 25; $i++) {

            $data = new BlogComment();
            $data->blog_id = rand(1, 24);
            $data->user_id = rand(1, 30);
            $data->comment = $faker->realTextBetween(50, 200);
            $data->save();

        }

        for($i = 1; $i < 240; $i++) {

            $data = new BlogComment();
            $data->blog_id = rand(1, 240);
            $data->user_id = rand(1, 30);
            $data->comment = $faker->realTextBetween(50, 200);
            $data->save();

        }

        //reply message
        // for($i = 1; $i < 25; $i++) {

        //     $data = new BlogComment();
        //     $data->blog_id = $i;
        //     $data->user_id = rand(1, 30);
        //     $data->comment = $faker->realTextBetween(20, 60);
        //     $data->parent_id = rand(1, 25);
        //     $data->save();

        // }
    }
}
