<?php

namespace App\Filters\Users;

use App\Filters\EloquentFilterContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UsersSearchFilter implements EloquentFilterContract
{
    public function __construct(
        protected Request $request
    )
    {
    }

    public function applyEloquent(Builder $model): Builder
    {
        if ($this->request->has('search')) {
             $model->where('username', 'like', '%' . $this->request->get('search') . '%');
        }
        if ($this->request->has('role_id')) {
             $model->whereHas('roles', function ($query) {
                    $query->where('id','=', $this->request->get('role_id'));
                });
        }
        return $model;
    }

    public static function getRequest(Request $request): static
    {
        return new static($request);
    }
}
