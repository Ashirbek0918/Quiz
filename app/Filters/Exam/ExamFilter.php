<?php

namespace App\Filters\Exam;

use App\Filters\EloquentFilterContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ExamFilter implements EloquentFilterContract
{
    public function __construct(
        protected Request $request
    )
    {
    }

    public function applyEloquent(Builder $model): Builder
    {
        if ($this->request->has('name') && $this->request->get('name')) {
            $model->where('name', 'like', '%' . $this->request->get('name') . '%');
        }
        if ($this->request->has('attempts_count') && $this->request->get('attempts_count')) {
            $model->where('attempts_count', '=', $this->request->get('attempts_count'));
        }
        if ($this->request->has('duration') && $this->request->get('duration')) {
            $model->where('duration', '=', $this->request->get('duration'));
        }
        if ($this->request->has('department_id') && $this->request->get('department_id')) {
            $model->where('department_id', '=', $this->request->get('department_id'));
        }
        return $model;
    }

    public static function getRequest(Request $request): static
    {
        return new static($request);
    }
}
