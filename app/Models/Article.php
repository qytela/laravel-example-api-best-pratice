<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use EloquentFilter\Filterable;
use App\Models\User;
use App\Models\Group;

class Article extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'type',
        'created_id',
    ];

    /**
     * Determine function on boot
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->created_id = auth()->id();
        });
    }

    /**
     * Relationship with user
     */
    public function scopeWithUser($q): Builder
    {
        return $q->with([
            'user' => function ($qb) {
                $qb->only(['id', 'name']);
            }
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'article_group');
    }
}
