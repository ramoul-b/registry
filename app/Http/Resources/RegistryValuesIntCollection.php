<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RegistryValuesIntCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($registryValue) {
            return new RegistryValuesIntResource($registryValue);
        })->toArray();
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('registry_values_int.index'),
            ],
        ];
    }
}
