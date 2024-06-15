<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\Helpers;
use Faker\Factory;
use App\Models\ProductCommentLike;

class ProductCommentLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $userIds = Helpers::generateNonRepeatingRandom(1, 30, 25);
        
        for($i = 1; $i < 25; $i++) {

            $data = new ProductCommentLike();
            $data->user_id = $userIds[$i];
            $data->product_comment_id = rand(1, 30);
            $data->save();

        }
    }
}
