<?php

namespace App\Http\Controllers;

use App\Enums\Module\ModuleStatusEnum;
use App\Http\Requests\ModuleRequest;
use App\Models\Permission;
use App\Services\ModuleService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModuleController extends Controller
{
    public function __construct(
        private readonly ModuleService $moduleService,
    ) {}

    public function index(Request $request)
    {
        return Inertia::render('Module/ModuleIndex', [
            'data' => $this->moduleService->get($request->all()),
            'statuses' => ModuleStatusEnum::toArray(),
            'permissions' => Permission::get(),
        ]);
    }

    public function store(ModuleRequest $request)
    {
        $this->moduleService->save($request->validated());

        return to_route('module.index')->with('success', __('lang.created_success', ['attribute' => __('module')]));
    }

    public function update(ModuleRequest $request, $id)
    {
        $this->moduleService->update($id, $request->validated());

        return to_route('module.index')->with('success', __('lang.updated_success', ['attribute' => __('module')]));
    }

    public function destroy(Request $request)
    {
        $ids = $request->get('ids');

        $this->moduleService->destroy($ids);

        return to_route('module.index')->with('success', __('lang.deleted_success', ['attribute' => __('module')]));
    }
}
