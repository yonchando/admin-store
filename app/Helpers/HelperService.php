<?php

namespace App\Helpers;

use App\Models\Setting;
use App\Services\Contracts\SettingRepositoryInterface;

readonly class HelperService
{
    public function __construct(
        private SettingRepositoryInterface $settingRepository,
    ) {}

    public function generateCardNumber($length = 16): string
    {
        $characters = '0123456789';
        $cardNumber = '';

        for ($i = 0; $i < $length; $i++) {
            $cardNumber .= $characters[rand(0, strlen($characters) - 1)];
            // Add a hyphen after every 4 characters (optional)
            if (($i + 1) % 4 === 0 && $i < $length - 1) {
                $cardNumber .= '-';
            }
        }

        return $cardNumber;
    }

    public function setting(): ?Setting
    {
        return $this->settingRepository->first();
    }
}
