<?php

namespace App\Http\Controllers;

use App\Enums\Module\ModuleStatusEnum;
use App\Http\Requests\ModuleRequest;
use App\Http\Resources\ModuleResource;
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
        $data = $this->moduleService->get($request->all());

        if ($request->wantsJson()) {
            return response()->json([
                'modules' => ModuleResource::collection($data),
            ]);
        }

        return Inertia::render('Module/ModuleIndex', [
            'data' => $data,
            'statuses' => ModuleStatusEnum::toArray(),
            'permissions' => Permission::get(),
            'requests' => $request->all(),
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
