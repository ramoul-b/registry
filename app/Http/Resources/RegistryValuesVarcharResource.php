<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistryValuesVarcharResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'registry_id' => $this->registry_id,
            'attribute_id' => $this->attribute_id,
            'value' => $this->value,
        ];
    }
}
