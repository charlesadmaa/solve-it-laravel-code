<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\CategoryForum;

class CategoryForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i < 25; $i++) {

            $data = new CategoryForum();
            $data->forum_id = $i;
            $data->forum_category_id = rand(1, 5);
            $data->save();

        }
    }
}
