<?php

namespace App\Traits;

trait Paginator
{
    public function getPerPage()
    {
        return request('perPage', 20);
    }
}
