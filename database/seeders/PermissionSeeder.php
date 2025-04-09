<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    protected array $permissions = [
        ["name" => "permissions.index", "guard_name" => "web",],
        ["name" => "permissions.store", "guard_name" => "web",],
        ["name" => "permissions.update", "guard_name" => "web",],
        ["name" => "permissions.delete", "guard_name" => "web",],

        ["name" => "roles.index", "guard_name" => "web",],
        ["name" => "roles.store", "guard_name" => "web",],
        ["name" => "roles.update", "guard_name" => "web",],
        ["name" => "roles.delete", "guard_name" => "web",],

        ["name" => "users.index", "guard_name" => "web",],
        ["name" => "users.store", "guard_name" => "web",],
        ["name" => "users.update", "guard_name" => "web",],
        ["name" => "users.delete", "guard_name" => "web",],



    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->permissions as $permission){
            if (!Permission::query()->where('name', $permission['name'])->exists()){
                Permission::query()->create($permission);
            }
        }
    }
}
