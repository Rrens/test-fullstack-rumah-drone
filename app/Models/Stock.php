<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'stocks';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'item_id',
        'supplier_id',
        'user_id',
        'type',
        'quantity',
        'date',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'id', 'supplier_id');
    }

    public function item()
    {
        return $this->hasMany(Product_items::class, 'id', 'item_id');
    }
}
