<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Like;
use App\Models\View;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Tag::factory(10)->create();
        Article::factory(10)->create();
        Comment::factory(10)->create();
        Like::factory(10)->create();
        View::factory(10)->create();

        $articles = Article::all();

        foreach ($articles as $article) {
            $article->tags()->attach(Tag::all()->random(rand(1, 3)));
            // $article->tags()->attach(Tag::all()->random(rand(1, 3)));
            // $article->tags()->attach(Tag::all()->random(rand(1, 3)));
        }


    }
}
