<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $files = File::files(app_path('Repositories/Contracts'));

        foreach ($files as $file) {
            $interface = "App\\Repositories\\Contracts\\{$file->getFilenameWithoutExtension()}";
            $classImpl = "App\\Repositories\\".Str::replace('Interface', '', $file->getFilenameWithoutExtension());

            /** @noinspection PhpUnusedLocalVariable */
            $this->app->bind($interface, $classImpl);
        }

    }

    public function boot(): void
    {
    }
}
