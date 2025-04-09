<?php
declare(strict_types=1);
namespace App\ActionData\Employees\EmployeeExamAttempt;

use Akbarali\ActionData\ActionDataBase;

class ParticipantAttemptCheckActionData extends ActionDataBase
{
    public ?array $checked_answers = [];


    public function prepare():void
    {
        $this->rules = [
          "checked_answers" => "nullable|array",
//          "answers.*" => "nullable|integer",
//          "answers.*.*" => "required|int",
        ];
    }
}
