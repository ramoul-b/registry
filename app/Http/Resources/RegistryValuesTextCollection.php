<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RegistryValuesTextCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($registryValue) {
            return new RegistryValuesTextResource($registryValue);
        })->toArray();
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('registry_values_text.index'),
            ],
        ];
    }
}
