<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class LogItemDetail extends Eloquent
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $connection = 'mongodb';
	protected $collection = 'log_item_detail';

    public function get_logitem()
    {
        return $this->belongsTo(LogItem::class, 'log_item_id', '_id');
    }

    public function get_item()
    {
        return $this->belongsTo(Goods::class, 'item_id', 'id');
    }
}
