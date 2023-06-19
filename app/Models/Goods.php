<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $connection = 'mysql';
    
    public function get_category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function item_satuan()
    {
        return $this->belongsToMany(Satuan::class, ItemSatuan::class, 'item_id', 'satuan_id');
    }
}
