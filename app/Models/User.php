<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Article;
use App\Models\Group;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The function takes a string as an argument, and sets the password attribute to the bcrypt of the
     * string
     * 
     * @param string password The password to be hashed.
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * It returns the first user that matches the username or email
     * 
     * @param string value The value of the unique identifier for the user.
     * 
     * @return The first user that matches the username or email.
     */
    public function findForPassport(string $value)
    {
        return $this->orWhere('username', $value)->orWhere('email', $value)->first();
    }

    /**
     * It returns the user with the id of the currently authenticated user, with the roles and
     * permissions of that user
     * 
     * @param q The query builder instance.
     * 
     * @return User A query builder object.
     */
    public function scopeMe($q): User
    {
        return $q->whereId(auth()->id())->with('roles.permissions')->first();
    }

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

    /**
     * It returns an array of the ids of the groups that the user belongs to
     * 
     * @return object An object
     */
    public function scopeGetGroupsId(): object
    {
        return auth()->user()->groups->pluck('id');
    }

    /**
     * If the user has groups, return true, otherwise return false
     * 
     * @return bool A boolean value.
     */
    public function scopeHasGroups(): bool
    {
        return auth()->user()->groups->count() > 0 ? true : false;
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'created_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_group');
    }
}
