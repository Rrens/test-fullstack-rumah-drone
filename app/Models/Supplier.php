<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'name',
        'phone',
        'address',
        'norek',
        'created_at',
        'updated_at',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}
