<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ArticleFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function title($value)
    {
        /** @var Builder $this */
        return $this->where(DB::raw('LOWER(title)'), 'like', '%' . strtolower($value) . '%');
    }

    public function type($value)
    {
        /** @var Builder $this */
        return $this->where('type', $value);
    }
}
