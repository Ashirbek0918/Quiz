<?php
declare(strict_types=1);
namespace App\ViewModels\Admin\Permission;

use Akbarali\ViewModel\BaseViewModel;
use Carbon\Carbon;

class PermissionViewModel extends BaseViewModel
{
    public int $id;
    public string $name;
    public Carbon|string $created_at = "";
    public string $guard_name;
    protected function populate():void
    {
        $this->created_at = $this->created_at->format('d-m-Y H-i');
    }
}
