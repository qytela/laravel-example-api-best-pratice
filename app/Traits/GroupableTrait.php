<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

trait GroupableTrait
{
    /**
     * Eligible groups for user group (exclude superadmin) has same model group
     */
    public function eligibleGroups(Model $model): Collection
    {
        if (!method_exists($model, 'groups')) abort(500, config('constants.errors.model_groups_undefined'));

        $groupIds = [];
        $tempGroupIds[] = Group::getGroupPublicId();

        if (auth()->check()) {
            /** @var \App\Models\User $user */
            $user = auth()->user();

            if ($user->isSuperadmin()) return $model->get();
            if ($user->hasGroups()) $tempGroupIds[] = $user->groupIds();
        }

        foreach ($tempGroupIds as $tempGroupId) {
            foreach ($tempGroupId as $groupId) {
                $groupIds[] = $groupId;
            }
        }

        return $model->whereHas('groups', function ($q) use ($groupIds) {
            $q->whereIn('id', $groupIds);
        })->get();
    }
}
