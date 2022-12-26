# Builder Macro

`App\Providers\BuilderServiceProvider`

> {primary.fa fa-info-circle} All builder macros placed here to be used in all models.

---

- [With Paginate](#with-paginate)
- [Exclude](#exclude)
- [Only](#only)

<a name="with-paginate"></a>

## With Paginate

Transform result to paginate.

---

If you has Request Controller then extends `YourRequest` with `PaginateRequest`

```php
use App\Http\Requests\PaginateRequest;

class YourRequest extends PaginateRequest
{
    // ...
}
```

Example, using `withPaginate(PaginateRequest)`

```php
// ... IoC Container

public function index(YourRequest $request): ModelResources
{
    return new ModelResources(
        $this->model->withPaginate($request)
    );
}

--- OR ---

public function index(PaginateRequest $request): ModelResources
{
    return new ModelResources(
        $this->model->withPaginate($request)
    );
}
```

Query / Params | Default |
:-           | :-        |
limit        | 10        |
page         | 1         |

<a name="exclude"></a>

## Exclude

Exclude certain columns from a query builder instance.

---

Example, using `exclude(array)`

```php
// ... IoC Container

public function index(): ModelResources
{
    return new ModelResources(
        $this->model->exclude(['name', 'username', 'email'])->get()
    );
}
```

<a name="only"></a>

## Only

Only include certain columns in a query builder instance.

---

Example, using `only(array)`

```php
// ... IoC Container

public function index(): ModelResources
{
    return new ModelResources(
        $this->model->only(['name', 'username', 'email'])->get()
    );
}
```