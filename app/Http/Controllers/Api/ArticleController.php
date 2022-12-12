<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\IndexRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use App\Traits\GroupableTrait;
use App\Models\Article;

class ArticleController extends Controller
{
    use GroupableTrait;

    protected ArticleService $articleService;
    protected Article $article;

    public function __construct(ArticleService $articleService, Article $article)
    {
        $this->articleService = $articleService;
        $this->article = $article;
    }

    public function index(IndexRequest $request): ArticleCollection
    {
        return new ArticleCollection(
            $this->eligibleGroups($this->article)->withPaginate($request)
        );
    }

    public function store(StoreRequest $request): ArticleResource
    {
        $article = $this->article->create($request->validated());
        $this->articleService->syncGroups($article, $request->validated()['groups']);

        return new ArticleResource($article);
    }
}
