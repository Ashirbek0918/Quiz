<?php

namespace App\Helpers;

if (!function_exists('participants')) {
    function participant(): \Illuminate\Contracts\Auth\Authenticatable|\App\Models\Participant
    {
        return auth('participants')->user();
    }
}
