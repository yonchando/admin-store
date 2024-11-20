<?php

namespace App\Services;

use App\Models\Module;
use Illuminate\Support\Collection;

class ModuleService
{
    /**
     * @return Collection<Module>
     */
    public function get(array $filters = []): Collection
    {
        return Module::with([
            'permissions' => function ($query) {
                return $query->ordered();
            },
        ])->filters($filters)->get();
    }

    public function save(array $data): Module
    {
        $module = new Module($data);

        $module->save();

        $module->givePermissionTo($data['permissions']);

        return $module;
    }

    public function update($id, array $data): ?Module
    {
        $module = Module::findOrFail($id);

        $module->fill($data);

        $module->save();

        $module->syncPermission($data['permissions']);

        return $module;
    }

    public function destroy(mixed $ids): array
    {
        Module::destroy($ids);

        return $ids;
    }
}
