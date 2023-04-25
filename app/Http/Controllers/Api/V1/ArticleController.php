<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ArticleComments;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\V1\BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5 OpenApi",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="darius@matulionis.lt"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

class ArticleController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/v1/articles",
     *     tags={"Articles"},
     *     summary="Article List",
     *     description="This show the list of article .",
     *      operationId="articlesList",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function articlesList()
    {
        $article = Article::orderBy('id', 'DESC')->get();
        if($article){
            $message = "Article List";
        }else{
            $message = "Article List Empty";
        }
        return $this->sendResponse($article, $message, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/articles/{id}",
     *     tags={"Article Page"},
     *     summary="Article Detail",
     *     description="This show the detail of an article .",
     *     operationId="articlePage",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="This show the detail of an article .",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="integer",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function articlePage($id)
    {
        $article = Article::find($id);
        if($article){
            $message = "Article Found";
        }else{
            $message = "Article Not Found";
        }
        return $this->sendResponse($article, $message, Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/articles/{id}/comment",
     *     tags={"Article Comment"},
     *     summary="Article Comment",
     *     description="This show the Comment of an article .",
     *     operationId="articleComment",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="This show the Comment of an article .",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="integer",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function articleComment($id)
    {
        $articleComments = ArticleComments::where('article_id', $id)->orderBy('id', 'DESC')->get();
        $data = [];

        if($articleComments){
            $message = "Article Comment List";
            foreach($articleComments as $index => $articleComment){
                $data[$index] = [
                    'article' => $articleComment->article->title,
                    'user' => $articleComment->user->name,
                    'comment' => $articleComment->comment,
                    'date' => $articleComment->created_at,
                ];
            }
        }else{
            $message = "Article Comment List Empty";
        }

        return $this->sendResponse($data, $message, Response::HTTP_CREATED);
    }


    /**
     * Add a new pet to the store.
     *
     * @OA\Post(
     *     path="/articlesCommentCreate",
     *     tags={"Articles Comment Create"},
     *     operationId="articleCommentCreate",
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="article_id",
     *                     description="Article ID",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="User Id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="comment",
     *                     description="Cpomment",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ) 
     * )
     */
    public function articleCommentCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_id' => ['required'],
            'user_id' => ['required'],
            'comment' => ['required'],
        ]);

        if ($validator->fails()){
            return $this->sendError('Validation Error.', $validator->messages());
        }else{
            $data = ArticleComments::create([
                'article_id' => $request->article_id,
                'user_id' => $request->user_id,
                'comment' => $request->comment,
            ]);

            $message = "Your message has been successfully sent";

            return $this->sendResponse($data, $message, Response::HTTP_CREATED);
        }
    }
    
    /**
     * @OA\Get(
     *     path="/api/v1/articles/{id}/like",
     *     tags={"Article like"},
     *     summary="Article like",
     *     description="This show the like of an article .",
     *     operationId="articleLike",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="This show the like of an article .",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="integer",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function articleLike($id)
    {
        $article = Article::find($id)->increment('likes');
        $message = "Like Increased";
        return $this->sendResponse($article, $message, Response::HTTP_CREATED);
    }
    
    /**
     * @OA\Get(
     *     path="/api/v1/articles/{id}/view",
     *     tags={"Article view"},
     *     summary="Article view",
     *     description="This show the view of an article .",
     *     operationId="articleView",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="This show the view of an article .",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(
     *                 type="integer",
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */
    public function articleView($id)
    {
        $article = Article::find($id)->increment('views');
        $message = "View Increased";
        return $this->sendResponse($article, $message, Response::HTTP_CREATED);
    }
    
}
