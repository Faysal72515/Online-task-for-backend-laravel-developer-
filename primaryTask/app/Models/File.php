<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $table = "file";
    protected $fillable = [
        'name',
        'file',
        'extension',
        'size',
        'description',
        'files_id',


        // 'item_id',
        // 'is_primary',

    ];

    public function one_to_many_relation_between_product_and_file(){
        return $this->hasMany(Product::class, 'file_id', 'id');
    }
    public function belongs_one_to_many_relation_bw_file_and_files(){
        return $this->belongsTo(Mainfile::class);
    }

}