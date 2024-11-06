<?php

namespace App\Models\Concerns\User;

use App\Enums\User\UserStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function statusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $status = $this->status;

                $trans = __("lang.$status->value");

                return match ($status->value) {
                    UserStatusEnum::ACTIVE->value => "<span class='badge badge-success'>$trans</span>",
                    default => "<span class='badge badge-danger'>$trans</span>"
                };
            }
        );
    }
}
