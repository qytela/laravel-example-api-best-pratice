<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
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
        'guard_name',
        'description',
    ];

    public const Member = 'member';

    /**
     * Count role record by role name
     */
    public function scopeCountRoleByName($q, string $name): int
    {
        return $q->whereName($name)->count() ?? 0;
    }
}
