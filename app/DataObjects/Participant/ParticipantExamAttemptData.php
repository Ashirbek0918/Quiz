<?php

namespace App\DataObjects\Participant;

use Akbarali\DataObject\DataObjectBase;

class ParticipantExamAttemptData extends DataObjectBase
{

    public ?int $id;
    public ?int $participant_id;
    public ?string $start_time;
    public ?string $end_time;
    public ?int $exam_id;
    public ?int $question_count;
    public ?int $correct_answers_count = 0;
    public ?array $questions;
    public ?array $participant_answers;
    public ?string $body = '';
    public ?bool $attempt_completed;
    public ?bool $exists_practical = true;
    public ?int $checked_by;
    public ?array $checked_answers = [];
}
