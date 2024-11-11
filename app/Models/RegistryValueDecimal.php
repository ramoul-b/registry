<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistryValueDecimal extends Model
{
    protected $fillable = [
        'registry_id', 'attribute_id', 'value'
    ];

    // Relationship to Registry
    public function registry()
    {
        return $this->belongsTo(Registry::class);
    }

    // Relationship to Attribute
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}

