<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
    public function getAllArticle($request);
    public function getArticleById($id);
    public function getBanner();
    public function createArticle(array $ArticleDetails);
    public function updateArticle(array $newDetails, $id);
    public function like($user_id, $article_id);
    public function deleteArticle($id);
}
