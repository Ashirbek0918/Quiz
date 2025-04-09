<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'username' => "superadmin",
            'password' => bcrypt("superadmin")
        ];

        $participant = [
            'fullname' => "User 1",
            'username' => "user",
            'password' => bcrypt("user")
        ];
        $newParticipant = Participant::query()->where('username', '=',$participant['username'])->first();
        if(!$newParticipant){
            PArticipant::query()->create($participant);
        }
        $newUser = User::query()->where('username', $user['username'])->first();
        if (!$newUser){
            $newUser = User::query()->create($user);
        }
        $newUser->syncRoles(Role::all());
    }
}
