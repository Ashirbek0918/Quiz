<?php

namespace App\DataObjects\Participant;

use Akbarali\DataObject\DataObjectBase;

class ParticipantWithExamAttemptData extends DataObjectBase
{


    public ?int $id;
    public ?string $fullname;
    public ?string $username;

    public  array|ParticipantExamAttemptData $participantExamAttempts = [];
}
