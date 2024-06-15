<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Interest;


class InterestSeeder extends Seeder
{

    public function run(): void
    {
    $interestList = [
      "Technology",
      "Fashion",
      "AI",
      "Game",
      "News",
      "Politics",
      "Football",
    ];

        foreach($interestList as $item){
            $interest = new Interest();
            $interest->name = $item;
            $interest->save();
        }

    }
}
