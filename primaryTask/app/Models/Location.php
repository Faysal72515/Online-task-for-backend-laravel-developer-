<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'country',
        'address_1',
        'address_2',
        'city',
        'state',
        'zone',
        'zip_code',
        'lat',
        'lng',
        'type',
    ];

    public function belongsto_one_to_one_location_item(){
        return $this->hasOne(Item::class, 'location_id', 'id');
    }
}