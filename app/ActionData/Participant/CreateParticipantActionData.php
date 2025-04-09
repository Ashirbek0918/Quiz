<?php

namespace App\ActionData\Participant;

use Akbarali\ActionData\ActionDataBase;

class CreateParticipantActionData extends ActionDataBase
{

    public ?int $id;
    public ?string $fullname;
    public ?string $username;
    public ?string $password;
    protected function prepare(): void
    {

        $this->rules = [
            'fullname' => ['required','string','max:255'],
            'username' => ['required','string','max:255','unique:participants,username'],
            'password' => ['required','string','min:8','max:255'],
        ];
    }
}
