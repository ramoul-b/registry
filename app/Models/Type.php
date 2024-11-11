<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'country', 'name', 'description', 'business_type_code',
        'has_vat_code', 'required_vat_code', 'vat_code_in_unique',
        'has_tax_identification', 'required_tax_identification', 'tax_identification_in_unique',
        'has_name', 'required_name', 'has_surname'
    ];

    public function registries()
    {
        return $this->hasMany(Registry::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}

