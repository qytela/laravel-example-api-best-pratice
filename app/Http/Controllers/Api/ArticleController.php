<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\IndexRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use App\Models\Article;

class ArticleController extends Controller
{
    protected Article $article;
    protected ArticleService $articleService;

    public function __construct(Article $article, ArticleService $articleService)
    {
        $this->article = $article;
        $this->articleService = $articleService;
    }

    public function index(IndexRequest $request): ArticleCollection
    {
        return new ArticleCollection(
            $this->articleService->getArticles($this->article, $request)
        );
    }

    public function store(StoreRequest $request): ArticleResource
    {
        $article = $this->article->create($request->validated());
        $this->articleService->syncGroups($article, $request->validated()['groups']);

        return new ArticleResource($article);
    }
}
