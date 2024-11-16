<?php

use App\Enums\Module\ModuleStatusEnum;
use App\Enums\Role\RoleStatusEnum;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Staff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status', 50)->default(ModuleStatusEnum::ACTIVE->value);
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            $table->unique(['code', 'guard_name']);
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->string('guard_name');
            $table->string('status', 50)->default(RoleStatusEnum::ACTIVE->value);
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->foreignIdFor(Permission::class, 'permission_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Module::class, 'module_id')->constrained()->cascadeOnDelete();

            $table->string('model_type');
            $table->foreignIdFor(Staff::class, 'model_id')->constrained()->cascadeOnDelete();
            $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->primary(['permission_id', 'model_id', 'model_type'],
                'model_has_permissions_permission_model_type_primary');
        });

        Schema::create('model_has_roles',
            function (Blueprint $table) {
                $table->foreignIdFor(Role::class, 'role_id');

                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->index(['model_id', 'model_type'],
                    'model_has_roles_model_id_model_type_index');

                $table->primary(['role_id', 'model_id', 'model_type'],
                    'model_has_roles_role_model_type_primary');
            });

        Schema::create('role_has_permissions', function (Blueprint $table) {
            $table->foreignIdFor(Permission::class, 'permission_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Role::class, 'role_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Module::class, 'module_id')->constrained()->cascadeOnDelete();
        });

        Schema::create('module_has_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Module::class, 'module_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Permission::class, 'permission_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('role_has_permissions');
        Schema::drop('model_has_roles');
        Schema::drop('model_has_permissions');
        Schema::drop('module_has_permissions');

        Schema::drop('modules');
        Schema::drop('roles');
        Schema::drop('permissions');
    }
};
