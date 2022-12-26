# Encrypt Response API

`App\Http\Middlewares\EncryptResponse`

> {primary.fa fa-info-circle} Encrypt response API with [`Crypt`](https://laravel.com/docs/9.x/encryption) package laravel if `APP_ENV=production`

<a></a>

> {danger.fa fa-exclamation-triangle} Make sure you already set `SECRET_CIPHER_KEY=`

---

- [Middleware](#middleware)
- [Testing](#testing)

<a name="middleware"></a>

## Middleware

Example, using `encrypt.response`
```php
Route::prefix('articles')->group(function () {
    Route::middleware(['auth.guest:api', 'encrypt.response'])->group(function () {
        Route::get('', [ArticleController::class, 'index']);
    });
});
```

Response
```json
{
    "payload": "eyJpdiI6InFBWWVhUE5xUWgyUlZVM1ZicGlldVE9PSIsInZhbHVlI..."
}
```

<a name="testing"></a>

## Testing

Example code to decrypt response API.

---

```js
const CryptoJS = require('crypto-js') // Anyway package for AES Decryption

const payload = () => {
  // Paste response payload
  return '...'
}

const data = JSON.parse(Buffer.from(payload(), 'base64'))
const iv = CryptoJS.enc.Base64.parse(data.iv)

/**
 * Paste your secret key without "base64:"
 * 
 * Example
 * SECRET_CIPHER_KEY=base64:go7kcs1Uw0PQ/nmuEpuJ7wGBzrF4vBdP+QnBrtYQdmA=
 * 
 * without "base64:"
 * const key = 'go7kcs1Uw0PQ/nmuEpuJ7wGBzrF4vBdP+QnBrtYQdmA='
 */
const key = 'SECRET_CIPHER_KEY'

const dec = CryptoJS.AES.decrypt(data.value, CryptoJS.enc.Base64.parse(key), { iv })
console.log(JSON.parse(dec.toString(CryptoJS.enc.Utf8)))
```

```json
{
  "data": [
    {
      "id": 1,
      "title": "New Article Release",
      "description": "New Article Release",
      "type": "PUBLIC",
      "created_id": 1,
      "created_at": "2022-12-11T16:57:33.000000Z",
      "updated_at": "2022-12-11T16:57:33.000000Z",
      "deleted_at": null
    }
  ],
  ...
}
```