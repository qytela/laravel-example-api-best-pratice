<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
         */
        Builder::macro('withPaginate', function (PaginateRequest $request): LengthAwarePaginator {
            $limit = $request->limit ?? 10;
            $page = $request->page ?? 1;

            /** @var Model $model */
            $model = $this;

            return $model->paginate($limit, '*', 'offset', $page);
        });
    }
}
