<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sales';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'invoice',
        'customer_id',
        'user_id',
        'total_price',
        'service',
        'final_price',
        'cash',
        'remaining',
        'note',
        'date',
        'created_at',
        'updated_at',
    ];

    public function customer()
    {
        return $this->hasMany(Customer::class, 'id', 'customer_id');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function sale_detail()
    {
        return $this->belongsTo(SaleDetail::class);
    }
}
