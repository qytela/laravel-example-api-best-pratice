<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
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
     * This function returns the name of the relation that is used to access the groups that a user
     * belongs to.
     * 
     * @return string The name of the relation.
     */
    public function scopeRelationGroupName(): string
    {
        return 'groups';
    }

    /**
     * It returns the id of the group named 'public'
     * 
     * @param q The query builder object
     * 
     * @return object A query builder object.
     */
    public function scopeGetGroupPublicId($q): object
    {
        return $q->whereName('public')->pluck('id');
    }
}
