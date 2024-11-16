<?php

namespace App\Models\Concerns\Staff;

use App\Models\Permission;
use App\Models\Role;

trait HasRelationships
{
    public function roles()
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles');
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'model', 'model_has_permissions')
            ->withPivot(['module_id'])
            ->as('module');
    }
}
