<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleTags;
use Faker\Factory as Faker; 
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach(range(1,20) as $index){
            $articleTag = ArticleTags::all()->random();

            Article::create([
                'title' => $faker->words(rand(2, 4), true),
                'short_desc' => $faker->paragraph(1),
                'body' => $faker->paragraph(5),
                'article_tag_id' => $articleTag->id,
                'thumbnail' => $faker->imageUrl(),
                'likes' => $faker->randomDigit,
                'views' => $faker->randomDigit,
                'created_at' => $faker->dateTimeThisMonth(),
            ]);
        }
    }
}
