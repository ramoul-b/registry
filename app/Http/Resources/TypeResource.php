<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => $this->country,
            'name' => $this->name,
            'description' => $this->description,
            'business_type_code' => $this->business_type_code,
            'has_vat_code' => $this->has_vat_code,
            'required_vat_code' => $this->required_vat_code,
            'vat_code_in_unique' => $this->vat_code_in_unique,
            'has_tax_identification' => $this->has_tax_identification,
            'required_tax_identification' => $this->required_tax_identification,
            'tax_identification_in_unique' => $this->tax_identification_in_unique,
            'has_name' => $this->has_name,
            'required_name' => $this->required_name,
            'has_surname' => $this->has_surname,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
