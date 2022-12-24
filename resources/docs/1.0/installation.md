# Installation Laravel Example API

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Setup Project](#setup-project)

<a name="requirements"></a>

## Requirements

Name     | Version
:-       | :-
PHP      | 7.3^
Composer | [Latest Version](https://getcomposer.org/download/)

<a name="installation"></a>

## Installation

Clone project first

```bash
git clone http://github.com/qytela/laravel-example-api
```

Then, install dependency with composer.

```bash
composer install
```

<a name="setup-project"></a>

## Setup Project

Copy `.env.example` to `.env`

```bash
cp .env.example .env
```

Generate App Key

```bash
php artisan key:generate
```

Setup `.env`

```bash
# Edit your own connection
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=example-api
DB_USERNAME=root
DB_PASSWORD=

# Encryption key
SECRET_CIPHER_KEY=
```

> {primary.fa fa-lightbulb-o} Best idea for `SECRET_CIPHER_KEY` is using `APP_KEY`
> and generate `php artisan key:generate` again.

Example                                                               |
:-                                                                    |
APP_KEY=base64:rlhd/YCkiXQ5rpgBvB3sojilelqExXJkJzBoYAC//kQ=           |
SECRET_CIPHER_KEY=base64:go7kcs1Uw0PQ/nmuEpuJ7wGBzrF4vBdP+QnBrtYQdmA= |

Migrate and seed database

```bash
php artisan migrate --seed
```

Setup passport

```bash
php artisan passport:install
```

> {warning.fa fa-info-circle} After setup passport, remember client secret key number two to login and retrieve bearer token.

Run application

```bash
php artisan serve
```

App | URL
:-  | :-
Web | http://localhost:8000
Api | http://localhost:8000/api