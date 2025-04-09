<?php
declare(strict_types=1);
namespace App\DataObjects\Quiz\Exam;
use Akbarali\DataObject\DataObjectBase;
use App\DataObjects\Participant\ParticipantExamAttemptData;

class ExamData extends DataObjectBase
{
    public int $id;
    public string $name;
    public int $attempts_count;
    public string $duration;
    public string $from_date;
    public string $to_date;
    public bool $status = false;
    public int $is_protected;
    public string $lang;
    public int $show_correct_answers;
    public ?string $created_at;
    public ?string $updated_at;
    public ?array $topics;
    public array|ParticipantExamAttemptData $participantAttempt;

}
