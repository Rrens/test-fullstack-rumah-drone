<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenerimaanDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penerimaan_details';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'penerimaan_id',
        'item_id',
        'pembelian_detail_id',
        'jumlah_penerimaan',
        'date',
        'created_at',
        'updated_at'
    ];

    public function penerimaan()
    {
        return $this->hasMany(penerimaan::class, 'id', 'penerimaan_id');
    }

    public function pembelian_detail()
    {
        return $this->hasMany(PembelianDetail::class,  'id', 'pembelian_detail_id');
    }
}
