<?php
declare(strict_types=1);
namespace App\ViewModels\Admin\Role;

use Akbarali\ViewModel\BaseViewModel;
use Carbon\Carbon;

class RoleViewModel extends  BaseViewModel
{
    public  int $id;
    public  string $name;
    public  string $guard_name;
    public Carbon|string  $created_at = "";
    public ?array $permissions;

    protected  function  populate():void
    {
        $this->created_at = $this->created_at->format('d-m-Y H:i');
    }
}
