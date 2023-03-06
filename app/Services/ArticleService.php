<?php

namespace App\Services;

use App\Helper\ImageHelper;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Support\Arr;

class ArticleService
{
    private $articleRepo;
    private $imageHelper;

    public function __construct(ArticleRepositoryInterface $articleRepo, ImageHelper $imageHelper)
    {
        $this->articleRepo = $articleRepo;
        $this->imageHelper = $imageHelper;
    }

    public function getArticleDetail($id)
    {
        return $this->articleRepo->getArticleById($id);
    }

    public function saveArticle($request)
    {
        return $this->articleRepo->createArticle($request);
    }

    public function editArticle($request, $article_id)
    {
        $articleDetail = $this->articleRepo->getArticleById($article_id);
        if (Arr::exists($request, 'thumbnail')) {
            if ($articleDetail->thumbnail != null) {
                $this->imageHelper->deleteImage($articleDetail->thumbnail);
            }
        }
        return $this->articleRepo->updateArticle($request, $article_id);
    }

    public function deleteArticle($article_id)
    {
        $articleDetail = $this->articleRepo->getArticleById($article_id);
        if ($articleDetail->thumbnail != null) {
            $this->imageHelper->deleteImage($articleDetail->thumbnail);
        }
        return $this->articleRepo->deleteArticle($article_id);
    }

    public function like($article_id)
    {
        return $this->articleRepo->like(Auth('api')->id(), $article_id);
    }

    public function uploadFile($request)
    {
        $filename = time() . "-article." . $request['image']->getClientOriginalExtension();
        $this->imageHelper->upload($request['image'], $filename);
        return $filename;
    }

    public function getBanner()
    {
        $articles = $this->articleRepo->getBanner();
        $banner = [];
        foreach ($articles as $key => $value) {
            $banner[$key] = ["title" => $value->title, "thumbnail" => $value->thumbnail];
        }
        return $banner;
    }

    public function getAllArticle($request)
    {
        return $this->articleRepo->getAllArticle($request);
    }
}
