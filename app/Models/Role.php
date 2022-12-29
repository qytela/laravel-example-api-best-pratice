<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;
use App\Traits\ClearsResponseCache;

class Role extends SpatieRole
{
    use HasFactory, SoftDeletes, ClearsResponseCache;

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
     * > Count the number of roles with the given name
     * 
     * @param q The query builder object
     * @param string name The name of the scope
     * 
     * @return int The number of roles with the name.
     */
    public function scopeCountRoleByName($q, string $name): int
    {
        return $q->whereName($name)->count() ?? 0;
    }
}
