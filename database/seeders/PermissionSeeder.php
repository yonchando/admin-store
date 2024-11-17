<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = config('permissions.permissions');

        $perms = [];
        foreach ($permissions as $permission) {
            $perms[] = Permission::create([
                'code' => Str::upper($permission),
                'name' => Lang::get('lang.'.$permission),
                'guard_name' => config('auth.defaults.guard'),
            ]);
        }
        $modules = config('permissions.modules');

        foreach ($modules as $key => $module) {
            $m = Module::create([
                'code' => Str::upper($key),
                'name' => __("lang.$key"),
            ]);

            foreach ($module as $item) {
                $p = collect($perms)->firstWhere('code', strtoupper($permissions[$item]));
                $m->givePermissionTo($p);
            }
        }

        $role = Role::create([
            'code' => 'USER',
            'name' => 'user',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo('STAFF', Permission::whereIn('code', ['READ', 'CREATE'])->get());
        $role->givePermissionTo('ROLE', Permission::whereIn('code', ['READ'])->get());

        $role = Role::create([
            'code' => 'manager',
            'name' => 'manager',
            'guard_name' => 'web',
        ]);
        $role->givePermissionTo('STAFF', Permission::whereIn('code', ['UPDATE', 'DELETE'])->get());
        $role->givePermissionTo('ROLE', Permission::whereIn('code', ['CREATE', 'UPDATE', 'DELETE'])->get());
    }
}
