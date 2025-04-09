<?php

namespace App\Models;

use App\Filters\Trait\EloquentFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function App\Helpers\employee;
use function App\Helpers\participant;

/**
 * @property int $id;
 * @property string $name;
 * @property int $attempts_count;
 * @property string $duration;
 * @property int $department_id;
 * @property string $from_date;
 * @property string $to_date;
 * @property bool $status;
 * @property int $organization_id;
 * @property array $topics;
 * @property int $is_protected;
 * @property string $lang;
 * @property int $show_correct_answers;
 * @property string $deleted_at;
 * @property string $created_at;
 * @property string $updated_at;
 */
class ExamModel extends Model
{
    use HasFactory, EloquentFilterTrait;
    protected $table = 'exams';
    protected $fillable = [
        "name",
        "attempts_count",
        "duration",
        "from_date",
        "to_date",
        "status",
        "is_protected",
        "lang",
        "topics",
        "show_correct_answers",
        "deleted_at",
        "created_at",
        "updated_at",
    ];
    protected $casts = [
      "topics" => "array"
    ];

    public function participant():BelongsTo
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
    public function participantAttempt():HasMany
    {
        return $this->hasMany(ParticipantExamAttemptModel::class, 'exam_id')
            ->orderByDesc("correct_answers_count")
            ->where('participant_id', '=', participant()->id);
    }

}
