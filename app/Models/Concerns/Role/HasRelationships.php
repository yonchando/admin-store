<?php

namespace App\Models\Concerns\Role;

use App\Models\Permission;

trait HasRelationships
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions')->withPivot(['module_id'])
            ->as('module');
    }
}
