<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembelianDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pembelian_details';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'pembelian_id',
        'jumlah_pembelian',
        'item_id',
        'created_at',
        'updated_at',
    ];

    public function item()
    {
        return $this->hasMany(ProductItems::class, 'id', 'item_id');
    }
}
