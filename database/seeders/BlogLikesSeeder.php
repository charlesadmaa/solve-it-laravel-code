<?php

namespace Database\Seeders;

use App\Models\BlogLikes;
use Illuminate\Database\Seeder;

class BlogLikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i < 25; $i++) {

            $data = new BlogLikes();
            $data->blog_id = $i;
            $data->user_id = rand(1, 30);
            $data->save();

        }

        for($i = 1; $i < 25; $i++) {

            $data = new BlogLikes();
            $data->blog_id = $i;
            $data->user_id = rand(1, 30);
            $data->save();

        }

        for($i = 1; $i < 25; $i++) {

            $data = new BlogLikes();
            $data->blog_id = $i;
            $data->user_id = rand(1, 30);
            $data->save();

        }

        for($i = 1; $i < 25; $i++) {

            $data = new BlogLikes();
            $data->blog_id = $i;
            $data->user_id = rand(1, 30);
            $data->save();

        }

        for($i = 1; $i < 25; $i++) {

            $data = new BlogLikes();
            $data->blog_id = $i;
            $data->user_id = rand(1, 30);
            $data->save();

        }

        for($i = 1; $i < 25; $i++) {

            $data = new BlogLikes();
            $data->blog_id = $i;
            $data->user_id = rand(1, 30);
            $data->save();

        }

        for($i = 1; $i < 200; $i++) {

            $data = new BlogLikes();
            $data->blog_id = rand(1, 240);
            $data->user_id = rand(1, 30);
            $data->save();

        }
    }
}
