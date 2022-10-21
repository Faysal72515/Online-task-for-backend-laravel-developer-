<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';

    protected $fillable = [
        'name', 'parent_id', 'is_active',
    ];

    public function one_to_many_category()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }
    public function has_many_products()
    {
        return $this->hasMany(Product::class, 'sub_category_id', 'id');
    }
}
