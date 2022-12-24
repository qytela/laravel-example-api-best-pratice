# Local Scope

`App\Models\*.php`

> {primary.fa fa-info-circle} Local scopes allow you to define common sets of query constraints that you may easily re-use throughout your application. For example, you may need to frequently retrieve all users that are considered "popular". To define a scope, prefix an Eloquent model method with scope.

References: [https://laravel.com/docs/9.x/eloquent#local-scopes](https://laravel.com/docs/9.x/eloquent#local-scopes)

---

Example from local scope in `User` model

```php
/**
 * Determine if user has role superadmin
 */
public function scopeIsSuperadmin(): bool
{
    /** @var User $user */
    $user = auth()->user();
    return $user->hasRole('superadmin') ? true : false;
}
```

and you can use for anywhere.

```php
// ... IoC Container

public function index()
{
    if ($this->user->isSuperadmin()) {
        // true
    } else {
        // false
    }
}
```