<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\PaginateRequest;

class BuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Add the 'with-paginate' to the builder.
         * Transform result to paginate.
         * 
         * @param PaginateRequest request The PaginateRequest instance containing the pagination request data.
         * 
         * @return LengthAwarePaginator A paginated list of results for the query
         */
        Builder::macro('withPaginate', function (PaginateRequest $request): LengthAwarePaginator {
            /** @var Builder $this */

            $limit = $request->limit ?? 10;
            $page = $request->page ?? 1;

            return $this->paginate($limit, '*', 'offset', $page);
        });

        /**
         * Add the 'exclude' to the builder.
         * Exclude certain columns from a query builder instance.
         * 
         * @param array columns An array of column names to exclude from the query.
         * 
         * @return Builder The modified query builder instance.
         */
        Builder::macro('exclude', function (array $columns): Builder {
            /** @var Builder $this */

            $model = $this->getModel();
            $tableColumns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());

            return $this->select(array_diff($tableColumns, $columns));
        });
    }
}
