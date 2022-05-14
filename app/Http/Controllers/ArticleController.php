<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Article;
use App\Models\Comment;
use App\Models\Like;
use App\Models\View;

class ArticleController extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/articles",
     *     tags={"articles"},
     *     summary="Get all articles",
     *     description="Returns all articles",
     *     operationId="getAllArticles",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid tag value"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag does not exist"
     *     )
     * )
     */
    public function allAticles(){
        $articles = Article::with(['comments', 'tags'])->orderBy('created_at', 'ASC')->withCount('views')->withCount('likes')->paginate(10);
        return response()->json($articles);
    }

    /**
     * @OA\Get(
     *     path="/articles/{id}",
     *     tags={"articles"},
     *     summary="Get single article",
     *     description="Returns single article",
     *     operationId="getSingleArticle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Article id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid tag value"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag does not exist"
     *     )
     * )
     */

    public function singleArticle($id){
        $article = Article::with(['comments', 'tags'])->where('id', $id)->withCount('views')->withCount('likes')->first();
        return response()->json($article);
    }

    /**
     * @OA\Get(
     *     path="/articles/{id}/comment",
     *     tags={"articles"},
     *     summary="Get all comments for article",
     *     description="Returns all comments for article",
     *     operationId="getAllCommentsForArticle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Article id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid tag value"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag does not exist"
     *     )
     * )
     */

    public function ArticleComments($id){
        $commets = Comment::where('article_id', $id)->get();
        return response()->json($commets);
    }


    /**
     * @OA\Get(
     *     path="/articles/{id}/views",
     *     tags={"articles"},
     *     summary="Get all views for article",
     *     description="Returns all views for article",
     *     operationId="getAllViewsForArticle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Article id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid tag value"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag does not exist"
     *     )
     * )
     */

    public function ArticleViews($id){
        $views = View::where('article_id', $id)->get();
        return response()->json($views);
    }

    /**
     * @OA\Get(
     *     path="/articles/{id}/like",
     *     tags={"articles"},
     *     summary="Get all likes for article",
     *     description="Returns all likes for article",
     *     operationId="getAllLikesForArticle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Article id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid tag value"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag does not exist"
     *     )
     * )
     */

    public function ArticleLikes($id){
        $likes = Like::where('article_id', $id)->get();
        return response()->json($likes);
    }

    /**
     * @OA\Post(
     *     path="/articles",
     *     tags={"articles"},
     *     summary="Create new article",
     *     description="Create new article",
     *     operationId="createNewArticle",
     *     @OA\RequestBody(
     *         description="Article object that needs to be added to the store",
     *         required=true,
     *         
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid tag value"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag does not exist"
     *     )
     * )
     */

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
        ]);

        $article = Article::create($request->all());
        $article->tags()->attach($request->tags);
        return response()->json($article);
    }



    /**
     * @OA\Post(
     *     path="/articles/{id}/like",
     *     tags={"articles"},
     *     summary="Create new like",
     *     description="Create new like",
     *     operationId="createNewLike",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Article id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Like object that needs to be added to the store",
     *         required=true,
     *
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid tag value"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag does not exist"
     *     )
     * )
     */

    public function like($id){
        $article = Article::find($id);
        $article->likes()->create();
        $article = Article::with(['comments', 'tags'])->where('id', $id)->withCount('views')->withCount('likes')->first();
        return response()->json($article);
    }



    /**
     * @OA\Post(
     *     path="/articles/{id}/view",
     *     tags={"articles"},
     *     summary="Create new view",
     *     description="Create new view",
     *     operationId="createNewView",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Article id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="View object that needs to be added to the store",
     *         required=true,
     *    
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid tag value"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag does not exist"
     *     )
     * )
     */


    public function view($id){
        $article = Article::find($id);
        $article->views()->create();
        $article = Article::with(['comments', 'tags'])->where('id', $id)->withCount('views')->withCount('likes')->first();
        return response()->json($article);
    }

    /**
     * @OA\Post(
     *     path="/articles/{id}/comment",
     *     tags={"articles"},
     *     summary="Create new comment",
     *     description="Create new comment",
     *     operationId="createNewComment",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Article id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Comment object that needs to be added to the store",
     *         required=true,
     *
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid tag value"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tag does not exist"
     *     )
     * )
     */


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
