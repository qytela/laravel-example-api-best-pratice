<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

trait GroupableTrait
{
    /**
     * Eligible group on user group (exclude superadmin) to according model group
     */
    public function eligibleGroups(Model $model): Builder
    {
        if (!method_exists($model, 'groups')) abort(500, config('constants.errors.model_groups_undefined'));

        $groupIds = [];
        $tempGroupIds[] = Group::getGroupPublicId();

        if (auth()->check()) {
            /** @var \App\Models\User $user */
            $user = auth()->user();

            if ($user->isSuperadmin()) return $model->whereHas('groups');
            if ($user->hasGroups()) $tempGroupIds[] = $user->groupIds();
        }

        foreach ($tempGroupIds as $tempGroupId) {
            foreach ($tempGroupId as $groupId) {
                $groupIds[] = $groupId;
            }
        }

        return $model->whereHas('groups', function ($q) use ($groupIds) {
            $q->whereIn('id', $groupIds);
        });
    }
}
