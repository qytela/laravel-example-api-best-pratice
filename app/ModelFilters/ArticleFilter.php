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

    /**
     * > Filter a query builder instance by the title field using a case-insensitive search.
     * 
     * @param value The value of the parameter.
     * 
     * @return Builder query builder object.
     */
    public function title($value): Builder
    {
        return $this->where(DB::raw('LOWER(title)'), 'like', '%' . strtolower($value) . '%');
    }

    /**
     * > Filter a query builder instance by the type field.
     * 
     * @param value The value to be used in the where clause.
     * 
     * @return Builder query builder instance.
     */
    public function type($value): Builder
    {
        return $this->where('type', $value);
    }
}
