<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Article\IndexRequest;
use App\Traits\GroupableTrait;
use App\Models\Article;
use App\Models\Group;

class ArticleService
{
    use GroupableTrait;

    protected Group $group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Show all article
     */
    public function getArticles(Article $article, IndexRequest $request): LengthAwarePaginator
    {
        return $this->eligibleGroups($article)
            ->filter($request->validated())
            ->exclude(['description'])
            ->withUser()
            ->withPaginate($request);
    }

    /**
     * Sync article with groups
     */
    public function syncGroups(Article $article, array $groups): void
    {
        $groupIds = [];

        if (count($groups) > 0) {
            foreach ($groups as $group) {
                $groupIds[] = $this->group->firstOrCreate([
                    'name' => Str::slug($group),
                    'display_name' => $group
                ])->id;
            }
        } else {
            $groupIds = $this->group->getGroupPublicId();
        }

        $article->groups()->sync($groupIds);
    }
}
