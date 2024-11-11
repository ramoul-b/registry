<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistryAccount extends Model
{
    protected $fillable = [
        'registry_id', 'account_id', 'type'
    ];

    // Relationship to Registry
    public function registry()
    {
        return $this->belongsTo(Registry::class);
    }

    // Assuming there's an Account model
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}

