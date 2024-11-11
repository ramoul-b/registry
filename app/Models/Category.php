<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'type_id'
    ];

    // Relationship with Type
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // If categories themselves are hierarchal or have other categorizations
    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}

