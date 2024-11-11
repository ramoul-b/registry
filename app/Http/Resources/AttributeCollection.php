<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($attribute) {
            return new AttributeResource($attribute);
        })->toArray();
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('attributes.index'),
            ],
        ];
    }
}
