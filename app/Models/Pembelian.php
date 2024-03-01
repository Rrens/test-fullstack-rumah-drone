<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pembelians';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'supplier_id',
        // 'item_id',
        // 'jumlah_pembelian',
        'tanggal_pembelian',
        'created_at',
        'updated_at',
    ];

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'id', 'supplier_id');
    }

    public function item()
    {
        return $this->hasMany(ProductItems::class, 'id', 'item_id');
    }

    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan::class);
    }
}
