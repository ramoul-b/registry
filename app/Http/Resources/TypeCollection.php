<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TypeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($type) {
            return new TypeResource($type);
        })->toArray();
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('types.index'),
            ],
        ];
    }
}
