<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\ArticleComments;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class ArticleCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach(range(1,20) as $index){
            $article = Article::all()->random();
            $user = User::all()->random();

            ArticleComments::create([
                'article_id' => $article->id,
                'user_id' => $user->id,
                'comment' => $faker->paragraph(1),
            ]);
        }
    }
}
