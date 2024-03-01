<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sale_details';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'sale_id',
        'item_id',
        'price',
        'jual',
        'qty',
        'discount_item',
        'total',
        'created_at',
        'updated_at',
    ];

    public function item()
    {
        return $this->hasMany(ProductItems::class, 'id', 'item_id');
    }

    public function sale()
    {
        return $this->hasMany(Sale::class, 'id', 'sale_id');
    }
}
