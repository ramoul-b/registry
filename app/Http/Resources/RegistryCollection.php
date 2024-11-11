<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RegistryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($registry) {
            return new RegistryResource($registry);
        })->toArray();
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('registries.index'),
            ],
        ];
    }
}
