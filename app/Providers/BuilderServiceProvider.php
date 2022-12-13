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
         * Add the with-paginate to the builder
         * 
         * Transform result to paginate
         */
        Builder::macro('withPaginate', function (PaginateRequest $request): LengthAwarePaginator {
            /** @var Builder $this */

            $limit = $request->limit ?? 10;
            $page = $request->page ?? 1;

            return $this->paginate($limit, '*', 'offset', $page);
        });
    }
}
