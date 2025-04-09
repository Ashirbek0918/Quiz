<?php

namespace App\Models;

use App\Filters\Trait\EloquentFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as RoleModel;

/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property string $created_at
 * @property string $updated_at
 */
class Role extends RoleModel
{
    use HasFactory, EloquentFilterTrait;

    protected $fillable = [
        'name',
        'guard_name',
    ];
}
