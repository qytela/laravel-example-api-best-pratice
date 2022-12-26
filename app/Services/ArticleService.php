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
     * It returns a paginated collection of articles that are eligible for the given article, filtered
     * by the given request, excluding the description, and eager loading the user.
     * 
     * @param Article article The article model
     * @param IndexRequest request The request object
     * 
     * @return LengthAwarePaginator A LengthAwarePaginator
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
     * It takes an array of group names, and if they don't exist, it creates them. Then it syncs the
     * article with the groups
     * 
     * @param Article article The article object
     * @param array groups array of group names
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
