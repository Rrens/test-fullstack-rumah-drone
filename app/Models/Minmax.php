<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Minmax extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'minmaxes';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'item_id',
        'stock',
        'stock_min',
        'stock_max',
        'safety_stock',
        'lead_time',
        'max_per',
        'rata_per',
        'restock',
        'month',
        'created_at',
        'updated_at',
    ];

    public function item()
    {
        return $this->hasMany(ProductItems::class, 'id', 'item_id');
    }
}
