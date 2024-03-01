<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'item_id',
        'user_id',
        'price',
        'total',
        'quantity',
        'jumlah_jual',
        'created_at',
        'updated_at',
    ];

    public function item()
    {
        return $this->hasMany(ProductItems::class, 'id', 'item_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
    // public function customer()
    // {
    //     return $this->hasMany(Customer::class, 'id', 'customer_id');
    // }
}
