<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Article;
use App\Models\Comment;
use App\Models\Like;
use App\Models\View;

class ArticleController extends Controller
{
    public function allAticles(){
        $articles = Article::with(['comments', 'tags'])->orderBy('created_at', 'ASC')->withCount('views')->withCount('likes')->paginate(10);
        return response()->json($articles);
    }

    public function singleArticle($id){
        $article = Article::with(['comments', 'tags'])->where('id', $id)->withCount('views')->withCount('likes')->first();
        return response()->json($article);
    }

    public function ArticleComments($id){
        $commets = Comment::where('article_id', $id)->get();
        return response()->json($commets);
    }

    public function ArticleViews($id){
        $views = View::where('article_id', $id)->get();
        return response()->json($views);
    }

    public function ArticleLikes($id){
        $likes = Like::where('article_id', $id)->get();
        return response()->json($likes);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
        ]);

        $article = Article::create($request->all());
        $article->tags()->attach($request->tags);
        return response()->json($article);
    }

    public function like($id){
        $article = Article::find($id);
        $article->likes()->create();
        $article = Article::with(['comments', 'tags'])->where('id', $id)->withCount('views')->withCount('likes')->first();
        return response()->json($article);
    }

    public function view($id){
        $article = Article::find($id);
        $article->views()->create();
        $article = Article::with(['comments', 'tags'])->where('id', $id)->withCount('views')->withCount('likes')->first();
        return response()->json($article);
    }

    public function comment(Request $request, $id){
        $this->validate($request, [
            'body' => 'required|string|max:255',
        ]);
        $article = Article::find($id);
        $article->comments()->create($request->all());
        $article = Article::with(['comments', 'tags'])->where('id', $id)->withCount('views')->withCount('likes')->first();
        return response()->json($article);
    }

    
}
