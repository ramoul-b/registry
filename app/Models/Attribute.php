<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'name', 'code', 'type'
    ];

    // Relationships with different attribute value tables
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
