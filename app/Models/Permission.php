<?php

namespace App\Models;

use App\Filters\Trait\EloquentFilterTrait;
use Spatie\Permission\Models\Permission as PermissionModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $guard_name
 * @method static applyEloquentFilters(iterable|null $filters)
 */
class Permission extends PermissionModel
{
    use HasFactory, EloquentFilterTrait;

    protected $fillable = [
        'name',
        'guard_name',
    ];
}
