<?php

namespace App\Models;

use App\Filters\Trait\EloquentFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id;
 * @property string $content;
 * @property boolean $is_correct;
 * @property int $question_id;
 * @property string $created_at;
 * @property string $updated_at;
 */
class AnswerModel extends Model
{
    use HasFactory, EloquentFilterTrait;
    protected $table = 'answers';
    protected $fillable = [
        'content',
        'is_correct',
        'question_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function scopeCorrect()
    {
        return $this->where('is_correct', true);
    }

}
