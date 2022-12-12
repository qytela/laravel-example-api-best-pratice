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
     * Find username or email
     */
    public function findForPassport(string $value)
    {
        return $this->orWhere('username', $value)->orWhere('email', $value)->first();
    }

    /**
     * Show my user only
     */
    public function scopeMyProfile($q): User
    {
        return $q->whereId(auth()->id())->with('roles.permissions')->first();
    }

    /**
     * Determine if user has role superadmin
     */
    public function scopeIsSuperadmin(): bool
    {
        /** @var User $user */
        $user = auth()->user();
        return $user->hasRole('superadmin') ? true : false;
    }

    /**
     * Get all user group id
     */
    public function scopeGetGroupsId(): object
    {
        return auth()->user()->groups->pluck('id');
    }

    /**
     * Determine if user has groups
     */
    public function scopeHasGroups(): bool
    {
        return auth()->user()->groups->count() > 0 ? true : false;
    }

    /**
     * Set password attribute to bcrypt
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'created_id', 'id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_group');
    }
}
