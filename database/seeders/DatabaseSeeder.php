<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SchoolsSeeder::class,
            DepartmentSeeder::class,
            LevelsSeeder::class,
            InterestSeeder::class,
            UserSeeder::class,
            GeneralSettingsSeeder::class,
            BlogCategorySeeder::class,
            BlogSeeder::class,
            CategoryBlogSeeder::class,
            BlogLikesSeeder::class,
            BlogCommentSeeder::class,
            BlogInterestTagSeeder::class,
            
            ForumSeeder::class,
            ForumCategorySeeder::class,
            CategoryForumSeeder::class,
            ForumCommentSeeder::class,

            ProductSeeder::class,
            ProductTagSeeder::class,
            ProductCommentSeeder::class,
            ProductCommentLikeSeeder::class,
        ]);
    }
}
