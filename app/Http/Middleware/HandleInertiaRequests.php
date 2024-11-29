<?php

namespace App\Http\Middleware;

use App\Enums\Setting\SettingKeyEnum;
use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;
use Session;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'lang' => fn () => Lang::get('lang'),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'info' => fn () => $request->session()->get('info'),
                'error' => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
            ],
            'setting' => fn () => Session::get('setting'),
            'routeName' => Route::currentRouteName(),
            'currency' => function () {
                return Session::remember('currency', function () {
                    $currencyId = Setting::keyBy(SettingKeyEnum::CURRENCY->value)->first()?->value;

                    return Currency::find($currencyId);
                });
            },
        ];
    }
}
