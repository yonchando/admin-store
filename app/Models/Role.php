<?php

namespace App\Models;

use App\Enums\Role\RoleStatusEnum;
use App\Models\Concerns\Role\HasAttributes;
use App\Models\Concerns\Role\HasRelationships;
use App\Models\Concerns\Role\HasScopes;
use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Role extends Model
{
    use HasAttributes;
    use HasFactory;
    use HasRelationships;
    use HasScopes;
    use HasTimestamps;

    protected $fillable = [
        'code',
        'name',
        'guard_name',
    ];

    protected $appends = [
        'status_text',
    ];

    protected function casts(): array
    {
        return [
            'status' => RoleStatusEnum::class,
        ];
    }

    public function givePermissionTo(int|string $key, mixed $permission): void
    {
        $this->permissions()->attach($permission, ['module_id' => $key]);
    }

    public function syncPermissions(int|string $key, mixed $permission): void
    {
        $ids = $this->permissions()->detach($this->permissions->pluck('id'));
        log_info('Detach', $ids);

        $this->permissions()->attach($permission, ['module_id' => $key]);
    }

    /**
     * Get permission ids with module id as key
     *
     * @return Collection<numeric>
     */
    public function getPermissionIds(): Collection
    {
        return $this->permissions->groupBy('pivot.module_id')->map(fn ($item) => $item->pluck('id')->values());
    }
}
