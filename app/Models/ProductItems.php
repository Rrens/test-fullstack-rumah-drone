<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductItems extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product_items';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'barcode',
        'name',
        'category_id',
        'price',
        'stock',
        'discount_item',
        'lead_time',
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->hasMany(ProductCategory::class, 'id', 'category_id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function sale_detail()
    {
        return $this->belongsTo(SaleDetail::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function history()
    {
        return $this->belongsTo(History::class);
    }

    public function minmax()
    {
        return $this->belongsTo(Minmax::class);
    }

    public function pembelian_detail()
    {
        return $this->belongsTo(PembelianDetail::class);
    }
}
