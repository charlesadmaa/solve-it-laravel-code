<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Levels;


class LevelsSeeder extends Seeder
{

    public function run(): void
    {
    $levelsList = [
      "100 Level",
      "200 Level",
      "300 Level",
      "400 Level",
      "500 Level",
      "Ond 1",
      "Ond 2",
      "HND 1",
      "HND 2",
      "Masters",
      "Phd",
    ];

        foreach($levelsList as $item){
            $level = new Levels();
            $level->name = $item;
            $level->save();
        }

    }
}
