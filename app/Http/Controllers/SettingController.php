<?php

namespace App\Http\Controllers;

use App\Enums\Setting\SettingKeyEnum;
use App\Http\Requests\Setting\SettingRequest;
use App\Models\Setting;
use App\Services\CurrencyService;
use App\Services\SettingService;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function __construct(
        private readonly CurrencyService $currencyService,
        private readonly SettingService $settingService
    ) {}

    public function show()
    {
        $settings = Setting::all();

        return Inertia::render('Setting/SettingShow', [
            'settings' => $settings,
            'currencies' => $this->currencyService->get(),
            'formData' => $settings->flatMap(fn ($setting) => [$setting->key => $setting->value]),
            'settingKeys' => SettingKeyEnum::toArray(),
            'logo' => Setting::findByKey('logo')?->append('logo_url'),
        ]);
    }

    public function update(SettingRequest $request)
    {
        $this->settingService->save($request);

        return back()->with('success', __('lang.updated_success', ['attribute' => __('lang.setting')]));
    }
}
