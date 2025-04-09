<?php

namespace App\Models;

use App\Filters\Trait\EloquentFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id;
 * @property int $employee_id;
 * @property string $start_time;
 * @property string $end_time;
 * @property int $exam_id;
 * @property int $question_count;
 * @property int $correct_answers_count;
 * @property array $questions;
 * @property array $employee_answers;
 * @property string $body;
 * @property int $checked_by;
 * @property array $checked_answers;
 * @property bool $exists_practical;
 * @property bool $attempt_completed;
 * @property int $organization_id;
 * @property string $created_at;
 * @property string $updated_at;
 *
 */
class ParticipantExamAttemptModel extends Model
{
    use HasFactory, EloquentFilterTrait;

    protected $table = 'participant_exam_attempts';
    protected $fillable = [
        "participant_id",
        "start_time",
        "end_time",
        "exam_id",
        "question_count",
        "correct_answers_count",
        "questions",
        "participant_answers",
        "body",
        "checked_by",
        "checked_answers",
        "attempt_completed",
        "exists_practical",
        "created_at",
        "updated_at",
    ];
    protected $casts = [
        "questions" => "array",
        "participant_answers" => "array",
        "checked_answers" => "array",
    ];
}
