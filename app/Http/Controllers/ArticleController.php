<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Requests\DislikeArticleRequest;
use App\Http\Requests\LikeArticleRequest;
use App\Http\Requests\UploadFileRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function getAllArticle(Request $request)
    {
        return new ArticleCollection($this->articleService->getAllArticle($request), 'success', "List Article Data");
    }

    public function getArticleDetail($article_id)
    {
        return $this->articleResponse($this->articleService->getArticleDetail($article_id), 'success', 'data found!');
    }

    public function addArticle(ArticleRequest $request)
    {
        return $this->articleResponse($this->articleService->saveArticle($request->validated()), "success", "article saved");
    }

    public function getBanner()
    {
        return response()->json([
            "status" => "success",
            "message" => "banner get succesfully",
            "data" => $this->articleService->getBanner(),
        ]);
    }

    public function editArticle(ArticleRequest $request, $article_id)
    {
        return $this->articleResponse($this->articleService->editArticle($request->validated(), $article_id), "success", "article updated");
    }

    public function deleteArticle($article_id)
    {
        return $this->articleResponse($this->articleService->deleteArticle($article_id), "success", "article deleted");
    }

    public function like($article_id)
    {
        $message = $this->articleService->like($article_id);
        return response()->json([
            "status" => "success",
            "message" => "$message successfully",
        ]);
    }

    public function uploadFile(UploadFileRequest $request)
    {
        $filename = $this->articleService->uploadFile($request);
        return response()->json([
            "status" => "success",
            "message" => "Upload success",
            "data" => [
                "filename" => $filename
            ]
        ]);
    }

    public function articleResponse($article, $status, $message)
    {
        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => new ArticleResource($article)
        ]);
    }
}
