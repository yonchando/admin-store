<?php

namespace App\Helpers;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Facades\Session;

class HelperService
{

    public function __construct(
        private readonly SettingRepositoryInterface $settingRepository,
    ) {
    }

    public function message($message, $type = 'success', $key = 'message'): void
    {
        Session::flash($key, [
            'text' => $message,
            'type' => $type,
        ]);
    }

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

    /**
     * @return Setting|null
     */
    public function setting(): Setting|null
    {
        return $this->settingRepository->first();
    }
}
