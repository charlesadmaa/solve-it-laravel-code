<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductTag;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1
        $tag = new ProductTag();
        $tag->title = 'Fashion'; 
        // $tag->created_by_id = 1; 
        $tag->save();
        
        //2
        $tag = new ProductTag();
        $tag->title = 'Saloon'; 
        // $tag->created_by_id = 1; 
        $tag->save();

        //3
        $tag = new ProductTag();
        $tag->title = 'Electricals'; 
        // $tag->created_by_id = 1; 
        $tag->save();

        //4
        $tag = new ProductTag();
        $tag->title = 'Materials'; 
        // $tag->created_by_id = 1; 
        $tag->save();

        //5
        $tag = new ProductTag();
        $tag->title = 'Grocery'; 
        // $tag->created_by_id = 1; 
        $tag->save();

        //6
        $tag = new ProductTag();
        $tag->title = 'Health'; 
        // $tag->created_by_id = 1; 
        $tag->save();

        //7
        $tag = new ProductTag();
        $tag->title = 'Beauty'; 
        // $tag->created_by_id = 1; 
        $tag->save();

        //8
        $tag = new ProductTag();
        $tag->title = 'Shoppings'; 
        // $tag->created_by_id = 1; 
        $tag->save();

    }
}
