# Auth Guest

`App\Http\Middlewares\AuthenticateWithGuest`

> {primary.fa fa-info-circle} API can be accessed even though not logged in.

---

Example, using `auth.guest:PROVIDER`
```php
Route::prefix('articles')->group(function () {
    Route::middleware(['auth.guest:api'])->group(function () { // Without logged in
        Route::get('', [ArticleController::class, 'index']);
    });
    Route::middleware(['auth:api'])->group(function () { // Required logged in
        Route::post('', [ArticleController::class, 'store']);
    });
});
```