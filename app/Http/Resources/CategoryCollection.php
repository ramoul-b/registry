<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($category) {
            return new CategoryResource($category);
        })->toArray();
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('categories.index'),
            ],
        ];
    }
}
