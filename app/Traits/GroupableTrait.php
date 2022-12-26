<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

trait GroupableTrait
{
    /**
     * This function returns a new instance of the Group class.
     * 
     * @return Group A new instance of the Group class.
     */
    private function loadGroupModel(): Group
    {
        return new Group();
    }

    /**
     * It returns a query builder object that will return all the records that are in the groups that
     * the user is a member of
     * 
     * @param Model model The model that you want to filter
     * 
     * @return Builder A collection of groups that the user is eligible to see.
     */
    public function eligibleGroups(Model $model): Builder
    {
        $this->isRelationExists($model);

        $groupIds = [];
        $tempGroupIds[] = $this->loadGroupModel()->getGroupPublicId();

        if (auth()->check()) {
            /** @var \App\Models\User $user */
            $user = auth()->user();

            if ($user->isSuperadmin()) return $this->onlyGroups($model);
            if ($user->hasGroups()) $tempGroupIds[] = $user->getGroupsId();
        }

        foreach ($tempGroupIds as $tempGroupId) {
            foreach ($tempGroupId as $groupId) {
                $groupIds[] = $groupId;
            }
        }

        return $this->onlyGroups($model, $groupIds);
    }

    /**
     * "If the user is in a group, only show them the records that are in their group, otherwise show
     * them all records."
     * 
     * The function is called like this:
     * 
     * @param Model model The model you're querying
     * @param array groupIds array of group ids
     * 
     * @return Builder A Builder object.
     */
    public function onlyGroups(Model $model, array $groupIds = []): Builder
    {
        $this->isRelationExists($model);

        /** @var Builder $model */
        return
            $model->whereHas(
                $this->loadGroupModel()->relationGroupName(),
                count($groupIds) > 0
                    ? function ($q) use ($groupIds) {
                        $q->whereIn('id', $groupIds);
                    }
                    : null
            )->orWhereDoesntHave($this->loadGroupModel()->relationGroupName());
    }

    /**
     * If the model doesn't have the relation defined, throw an error.
     * 
     * @param Model model The model that you want to check if it has a relation.
     */
    protected function isRelationExists(Model $model)
    {
        if (!method_exists($model, $this->loadGroupModel()->relationGroupName())) abort(500, config('constants.errors.model_groups_undefined'));
    }
}
