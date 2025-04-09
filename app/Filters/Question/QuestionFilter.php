<?php

namespace App\Filters\Question;

use App\Filters\EloquentFilterContract;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QuestionFilter implements EloquentFilterContract
{
    public function __construct(
        protected Request $request
    )
    {
    }
    public function applyEloquent(Builder $model): Builder
    {
        if ($this->request->has('topic_id')) {
            $model->where('topic_id', '=', $this->request->get('topic_id'));
        }
        return $model;
    }

    public static function getRequest(Request $request): static
    {
        return new static($request);
    }
}
