<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create();

        for($i = 1; $i < 55; $i++) {
            $data = new Product();
            $data->title = $faker->realTextBetween(12, 20);
            $data->description = $faker->realTextBetween(100, 255);
            $data->type = 'product';
            $data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->created_by_id = 1;
            $data->amount = rand(1000, 100000);
            $data->product_tag_id = rand(1, 8);
            $data->location = 'Lagos Island';
            $data->phone = '08011223344';
            $data->whatsapp = '08011223344';
            $data->is_featured = rand(0, 1);
            $data->save();
        }

        //type service
        for($i = 1; $i < 55; $i++) {
            $data = new Product();
            $data->title = $faker->realTextBetween(12, 20);
            $data->description = $faker->realTextBetween(100, 255);
            $data->type = 'service';
            $data->featured_image = "default-placeholder-".rand(1, 4).".png";
            $data->created_by_id = 1;
            $data->amount = rand(1000, 100000);
            $data->product_tag_id = rand(1, 8);
            $data->location = 'Victoria Island';
            $data->phone = '02011223344';
            $data->whatsapp = '02011223344';
            $data->is_featured = rand(0, 1);
            $data->save();
        }

    }
}
