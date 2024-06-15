<?php

namespace Database\Seeders;

use App\Models\BlogInterestTag;
use Illuminate\Database\Seeder;

class BlogInterestTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i < 240; $i++) {
            $data = new BlogInterestTag();
            $data->blog_id =  $i;
            $data->interest_id = rand(1, 7);
            $data->save();
        }

    }
}
