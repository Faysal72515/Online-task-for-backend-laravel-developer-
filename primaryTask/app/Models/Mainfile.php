<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mainfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'is_primary',
    ];

    public function one_to_many_relation_between_files_and_files(){
        return $this->hasMany(File::class,'files_id', 'id');
    }

    public function belongs_one_to_many_items(){
        return $this->belongsTo(Item::class);
    }
}