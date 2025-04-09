<?php

namespace App\ViewModels\Admin\Users;

use Akbarali\ViewModel\BaseViewModel;

class UserProfieViewModel extends BaseViewModel
{
    public int $id;
    public string $username;

    protected function populate()
    {
    }
}
