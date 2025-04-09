<?php

namespace App\DataObjects\User;

use Akbarali\DataObject\DataObjectBase;

class UserProfileData extends DataObjectBase
{

    public ?int    $id;
    public ?string $username;
}
