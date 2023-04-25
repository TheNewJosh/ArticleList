<?php

namespace Database\Seeders;

use App\Models\ArticleTags;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker; 

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach(range(1,4) as $index){
            ArticleTags::create([
                'label' => $faker->words(1, true),
                'url' => $faker->url(),
            ]);
        }
    }
}
