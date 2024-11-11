<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RegistryValuesVarcharCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($registryValue) {
            return new RegistryValuesVarcharResource($registryValue);
        })->toArray();
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('registry_values_varchar.index'),
            ],
        ];
    }
}
