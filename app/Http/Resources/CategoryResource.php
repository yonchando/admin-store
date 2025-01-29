<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Category */
class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'category_name' => $this->category_name,
            'slug' => $this->slug,
            'json' => $this->json,
            'created_at' => $this->created_at,
            'children_count' => $this->whenCounted('children', default: 0),
            'children' => CategoryResource::collection($this->whenLoaded('children', default: [])),
            'open' => false,
        ];
    }
}
