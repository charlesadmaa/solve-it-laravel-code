<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\ProductComment;

class ProductCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        //message only
        for($comment = 1; $comment < 25; $comment++) {

            $data = new ProductComment();
            $data->product_id = $comment;
            $data->created_by_id = rand(1, 30);
            $data->message = $faker->realTextBetween(20, 60);
            $data->save();

            //comment replies
            for($i = 1; $i < 25; $i++) {
                $data = new ProductComment();
                $data->product_id = $i;
                $data->created_by_id = rand(1, 30);
                $data->message = $faker->realTextBetween(20, 60);
                $data->parent_id = $comment;
                $data->save();
            }

            for($i = 1; $i < 25; $i++) {
                $data = new ProductComment();
                $data->product_id = $i;
                $data->created_by_id = rand(1, 30);
                $data->message = $faker->realTextBetween(20, 60);
                $data->parent_id = $comment;
                $data->save();
            }
        }

        for($comment = 1; $comment < 50; $comment++) {
            $data = new ProductComment();
            $data->product_id = $comment;
            $data->created_by_id = rand(1, 30);
            $data->message = $faker->realTextBetween(20, 60);
            $data->save();
        }
    }
}
