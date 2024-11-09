<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Lang;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = config('permissions.permissions');

        $perms = [];
        foreach ($permissions as $permission) {
            $perms[] = Permission::createOrFirst(['code' => $permission], [
                'code' => $permission,
                'name' => Lang::get('lang.'.$permission),
                'guard_name' => config('auth.defaults.guard'),
            ]);
        }
        $modules = config('permissions.modules');

        foreach ($modules as $key => $module) {
            $m = Module::createOrFirst([
                'name' => __("lang.$key"),
            ]);

            foreach ($module as $item) {
                $p = collect($perms)->firstWhere('code', $permissions[$item]);
                $m->givePermissionTo($p);
            }
        }
    }
}
