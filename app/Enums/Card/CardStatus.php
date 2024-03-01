<?php

namespace App\Enums\Card;

enum CardStatus
{
    case ACTIVE;
    case INACTIVE;
    case EXPIRED;
    case SUSPECT;
    case BLOCK;
}
