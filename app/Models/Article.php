<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
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
        'thumbnail',
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

    protected function setThumbnailAttribute($thumbnail)
    {
        if (!is_null($thumbnail)) {
            $path = $thumbnail->store('articles/thumbnails', 'public');
            $this->attributes['thumbnail'] = $path;
        }
    }

    protected function getThumbnailAttribute($path)
    {
        /** @var Storage $public  */
        $public = Storage::disk('public');

        if ($public->exists($path)) {
            return $public->url($path);
        }

        return null;
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
