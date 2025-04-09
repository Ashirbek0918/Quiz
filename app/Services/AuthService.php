<?php

namespace App\Services;

use App\ActionData\User\LoginUserActionData;
use App\DataObjects\Auth\AuthDataObject;
use App\Exceptions\OperationException;
use App\Models\Employee;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public static function login(LoginUserActionData $data): bool
    {
        $user = User::query()->where('username', $data->username)->first();
        if (is_null($user) || !Hash::check($data->password, $user->password)) {
            return false;
        }
        Auth::login($user);
        return true;
    }

    public function loginParticipant(LoginUserActionData $data): bool
    {
        $participant = Participant::query()->where('username', $data->username)->first();
        if (is_null($participant) || !Hash::check($data->password, $participant->password)) {
            return false;
        }
        Auth::guard('participants')->attempt($data->all());

        return true;
    }
}
