<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    private $articles;

    public function __construct()
    {
        $this->articles = new Article();
    }
    public function getAllArticle($request)
    {
        $q = $this->articles::with('author')->withCount('likes');

        $q->when($request->search, function ($q) use ($request) {
            $q->where('title', 'ilike', "%$request->search%");
        });

        $q->when($request->latest == true, function ($q) {
            $q->latest();
        });

        $q->when($request->popular == true, function ($q) {
            $q->orderByDesc('likes_count');
        });

        return $q->simplePaginate($request->per_page ?? 15);
    }

    public function getArticleById($id)
    {
        return $this->articles::with('author')->withCount('likes')->findorfail($id);
    }

    public function getBanner()
    {
        return $this->articles::withCount('likes')->orderByDesc('likes_count')->take(3)->get();
    }

    public function createArticle($articleDetails)
    {
        return $this->articles::create($articleDetails);
    }

    public function updateArticle($newDetails, $id)
    {
        return tap($this->articles::findorfail($id))->update($newDetails);
    }

    public function deleteArticle($id)
    {
        return tap($this->articles::findorfail($id))->delete();
    }

    public function like($user_id, $article_id)
    {
        $article = $this->articles::findorfail($article_id);
        if ($article->likes()->where('user_id', $user_id)->exists()) {
            $article->likes()->detach($user_id);
            return "like removed";
        } else {
            $article->likes()->attach($user_id);
            return "liked";
        }
    }
}
