<?php

namespace App\Models;

use App\Filters\Trait\EloquentFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id;
 * @property string $content;
 * @property int $type;
 * @property string $lang;
 * @property int $topic_id;
 * @property string $created_at;
 */
class QuestionModel extends Model
{
    use HasFactory, EloquentFilterTrait;
    protected $table = 'questions';
    protected $fillable = [
      'content',
      'type',
      'lang',
      'topic_id',
    ];

    public function answers():HasMany
    {
        return $this->hasMany(AnswerModel::class, 'question_id');
    }
}
