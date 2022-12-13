<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

trait GroupableTrait
{
    /**
     * Load model
     */
    private function loadGroupModel(): Group
    {
        return new Group();
    }

    /**
     * Eligible group on user group (exclude superadmin) to according model group
     */
    public function eligibleGroups(Model $model): Builder
    {
        if (!method_exists($model, $this->loadGroupModel()->relationGroupName())) abort(500, config('constants.errors.model_groups_undefined'));

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
     * Returns only to the specified group
     */
    public function onlyGroups(Model $model, array $groupIds = []): Builder
    {
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
}
