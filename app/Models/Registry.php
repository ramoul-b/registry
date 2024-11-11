<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
    protected $fillable = [
        'type_id', 'country', 'vat_code_country', 'vat_code',
        'tax_identification_country', 'tax_identification', 'unique_code',
        'name', 'surname', 'business_name'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function addresses()
    {
        return $this->hasMany(RegistryAddress::class);
    }

    public function accounts()
    {
        return $this->hasMany(RegistryAccount::class);
    }

    // Assuming relationships with RegistryValue models
    public function intValues()
    {
        return $this->hasMany(RegistryValueInt::class);
    }

    public function varcharValues()
    {
        return $this->hasMany(RegistryValueVarchar::class);
    }

    public function decimalValues()
    {
        return $this->hasMany(RegistryValueDecimal::class);
    }

    public function textValues()
    {
        return $this->hasMany(RegistryValueText::class);
    }
}
