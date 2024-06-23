<?php

namespace App\Models\Concerns;

use App\Models\User;

trait HasCreator
{
    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}