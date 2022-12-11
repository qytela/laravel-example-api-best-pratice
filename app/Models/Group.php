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

        static::creating(function ($item) {
            $item->created_id = auth()->id();
        });
    }

    /**
     * Get group id only public
     */
    public function scopeGetGroupPublicId($q): object
    {
        return $q->where('name', 'public')->pluck('id');
    }
}
