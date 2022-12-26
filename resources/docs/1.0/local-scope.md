# Local Scope

`App\Models\*.php`

> {primary.fa fa-info-circle} Local scopes allow you to define common sets of query constraints that you may easily re-use throughout your application. For example, you may need to frequently retrieve all users that are considered "popular". To define a scope, prefix an Eloquent model method with scope.

References: [https://laravel.com/docs/9.x/eloquent#local-scopes](https://laravel.com/docs/9.x/eloquent#local-scopes)

---

Example from local scope on `User` model

```php
/**
 * If the user is logged in and has the role of superadmin, return true, otherwise return false
 * 
 * @return bool A boolean value.
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