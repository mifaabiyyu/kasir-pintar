<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class LogItem extends Eloquent
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $connection = 'mongodb';
	protected $collection = 'log_item';

    public function get_detail()
    {
        return $this->hasMany(LogItemDetail::class, 'log_item_id', 'id');
    }

    public function get_vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor', 'id');
    }
}
