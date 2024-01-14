<?php

namespace App\Models\Concerns\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait HasScopes
{
    public function scopeIsNotAdmin(Builder $query): Builder
    {
        return $query->where('is_admin', false);
    }

    public function scopeFilters(Builder $query, Request $request): Builder
    {
        if (!is_null($search = $request->get('search_text'))) {
            $query->where(
                fn(Builder $query) => $query->whereRaw(
                    'lower(name) like lower(?) or lower(username) like lower(?)',
                    ["%$search%", "%$search%"]
                )
            );
        }

        if (!is_null($gender = $request->get('gender'))) {
            $query->where('gender', $gender);
        }

        if (!is_null($status = $request->get('status'))) {
            $query->where('status', $status);
        }

        return $query;
    }
}