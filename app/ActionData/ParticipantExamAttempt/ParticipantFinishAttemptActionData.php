<?php
declare(strict_types=1);
namespace App\ActionData\ParticipantExamAttempt;
use Akbarali\ActionData\ActionDataBase;

class ParticipantFinishAttemptActionData extends ActionDataBase
{
    public ?array $answers;


    public function prepare():void
    {
        $this->rules = [
          "answers" => "required|array",
//          "answers.*" => "nullable|integer",
//          "answers.*.*" => "required|int",
        ];
    }
}
