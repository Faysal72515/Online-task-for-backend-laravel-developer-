<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_type',
        'location_id',
        'tradable',
        'user_id',
        'status',
        'is_active',
    ];

    public function one_to_one_bw_item_location(){
        return $this->hasOne(Location::class, 'location_id', 'id');
    }

    public function store_one_to_many_items(){
        return $this->hasMany(Mainfile::class, 'item_id','id');
    }

    public function one_to_many_product(){
        return $this->hasMany(Product::class, 'item_id','id');
    }
}