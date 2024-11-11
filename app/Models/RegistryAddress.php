<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistryAddress extends Model
{
    protected $fillable = [
        'registry_id', 'address_id', 'type'
    ];

    // Relationship to Registry
    public function registry()
    {
        return $this->belongsTo(Registry::class);
    }

    // Assuming there's an Address model or placeholder until the microservice is ready
    public function address()
    {
        return $this->belongsTo(Address::class); // Adjust this as needed based on microservice integration
    }
}
