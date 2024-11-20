<?php

namespace App\Helpers;

use App\Casts\Images\ImageCast;
use Illuminate\Http\UploadedFile;

class HelperService
{
    public function __construct(
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

    public function imageInit(UploadedFile $file, string $path): ImageCast
    {
        $image = new ImageCast;

        $image->filename = $file->hashName();
        $image->path = $path;
        $image->extension = $file->getClientOriginalExtension();
        $image->originalName = $file->getClientOriginalName();
        $image->url = \Storage::url($image->path.'/'.$image->filename);

        return $image;
    }
}
