<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'item_id',
        'category_id',
        'sub_category_id',
        'negotiable',
        'price',
        'condition',
        'description',
        'min_quantity',
        'file_id',
    ];

    public function categories(){
        return $this->belongsToMany(Category::class)->withPivot('active', 'created_by');
    }
    public function one_to_many_product(){
        return $this->belongsTo(Item::class);
    }

    public function belongsto_many_subcategories(){
        return $this->belongsTo(Subcategory::class);
    }
}