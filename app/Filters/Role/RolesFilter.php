<?php

namespace App\Filters\Role;

use App\Filters\EloquentFilterContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RolesFilter implements EloquentFilterContract
{
    public function __construct(
        protected Request $request
    )
    {
    }
    public function applyEloquent(Builder $model): Builder
    {
        if ($this->request->has('name')) {
            return $model
                ->where('name', 'like', '%' . $this->request->get('name') . '%');
        }
        return $model;
    }

    public static function getRequest(Request $request): static
    {
        return new static($request);
    }
}
