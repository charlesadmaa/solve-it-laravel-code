<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\ForumComment;

class ForumCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        //message only
        for($i = 1; $i < 25; $i++) {

            $data = new ForumComment();
            $data->forum_id = $i;
            $data->created_by_id = rand(1, 30);
            $data->message = $faker->realTextBetween(20, 60);
            $data->file = "default-image.png";
            $data->file_type = 'image';
            $data->save();

        }

        //reply message
        for($i = 1; $i < 25; $i++) {

            $data = new ForumComment();
            $data->forum_id = $i;
            $data->created_by_id = rand(1, 30);
            $data->message = $faker->realTextBetween(20, 60);
            $data->file = "default-image.png";
            $data->file_type = 'image';
            $data->save();

        }

        //message with file
        for($i = 1; $i < 10; $i++) {

            $data = new ForumComment();
            $data->forum_id = $i;
            $data->created_by_id = rand(1, 30);
            $data->message = $faker->realTextBetween(20, 60);
            $data->file = "default-image.png";
            $data->file_type = 'image';
            $data->save();

        }
    }
}
