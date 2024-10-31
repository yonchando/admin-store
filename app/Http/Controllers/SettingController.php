<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\SettingRequest;
use App\Services\Contracts\CurrencyRepositoryInterface;
use App\Services\Contracts\SettingRepositoryInterface;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingRepositoryInterface $settingRepository,
        private readonly CurrencyRepositoryInterface $currencyRepository,
    ) {}

    public function show()
    {
        return Inertia::render('Setting/Show', [
            'setting' => session('setting', $this->settingRepository->first()),
            'currencies' => $this->currencyRepository->get(),
        ]);
    }

    public function update(SettingRequest $request)
    {
        $setting = $this->settingRepository->update($request);

        session()->forget('setting');
        session()->put('setting', $setting);

        return redirect()->route('setting.show')->with('success', __('lang.updated_success', ['attribute' => __('lang.setting')]));
    }
}
