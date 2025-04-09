<?php
declare(strict_types=1);
namespace App\ViewModels\Admin\Users;

use Akbarali\ViewModel\BaseViewModel;
use Carbon\Carbon;

class UserViewModel extends BaseViewModel
{

    public int $id;
    public string $username;
    public $roles ;
    protected function populate():void
    {
    }
}
