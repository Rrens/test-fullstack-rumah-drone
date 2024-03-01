<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'name',
        'gender',
        'phone',
        'address',
        'created_at',
        'updated_at'
    ];

    public function sale()
    {
        return $this->belongsTo(sale::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
