<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use EloquentFilter\Filterable;
use App\Traits\ClearsResponseCache;
use App\Models\User;
use App\Models\Group;

class Article extends Model
{
    use HasFactory, SoftDeletes, Filterable, ClearsResponseCache;

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

        // A function that is called when the model is created
        static::creating(function ($item) {
            $item->created_id = auth()->id();
        });
    }

    /**
     * If the thumbnail is not null, then store the thumbnail in the public/articles/thumbnails
     * directory and set the thumbnail attribute to the path of the thumbnail
     * 
     * @param thumbnail The name of the file input field in the form.
     */
    protected function setThumbnailAttribute($thumbnail)
    {
        if (!is_null($thumbnail)) {
            $path = $thumbnail->store('articles/thumbnails', 'public');
            $this->attributes['thumbnail'] = $path;
        }
    }

    /**
     * If the file exists, return the url, otherwise return null
     * 
     * @param path The path to the file.
     * 
     * @return string The url of the image.
     */
    protected function getThumbnailAttribute($path): string
    {
        /** @var Storage $public  */
        $public = Storage::disk('public');

        if ($public->exists($path)) {
            return $public->url($path);
        }

        return $public->url('images/no_image.jpg');
    }

    /**
     * "When you call the `withUser` function on a query builder, it will return the query builder with
     * the `user` relationship eager loaded."
     * 
     * @param q The query builder instance.
     * 
     * @return Builder A query builder instance.
     */
    public function scopeWithUser($q): Builder
    {
        return $q->with(['user:id,name']);
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
