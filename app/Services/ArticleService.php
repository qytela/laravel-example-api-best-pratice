<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Group;

class ArticleService
{
    protected Group $group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Sync groups
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
