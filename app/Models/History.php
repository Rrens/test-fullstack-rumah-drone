<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'history';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'item_id',
        'date',
        'total',
        'created_at',
        'updated_at',
    ];

    public function item()
    {
        return $this->hasMany(ProductItems::class, 'id', 'item_id');
    }
}
