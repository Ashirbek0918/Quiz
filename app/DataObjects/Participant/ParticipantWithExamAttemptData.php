<?php

namespace App\DataObjects\Participant;

use Akbarali\DataObject\DataObjectBase;

class ParticipantWithExamAttemptData extends DataObjectBase
{


    public int $id;
    public string $fullname;
    public string $username;
    public  string $pinfl;
    public string $birthdate;
    public string $passport;
    public int $branchId;
    public int $positionId;

    public  array|ParticipantExamAttemptData $participantExamAttempts = [];
}
