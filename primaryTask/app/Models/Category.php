<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type',  'is-active',
    ];

    public function one_to_many(){
        return $this->hasMany(Subcategory::class, 'parent_id', 'id');
    }

    public function one_to_many_products(){
        return $this->belongsToMany(Product::class);
    }
}