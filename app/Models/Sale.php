<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'table_id',
        'user_id',
        'total_price',
        'total_recieved',
        'change',
        'payment_type',
        'status',
    ];
    public function saleDetails(){
        return $this->hasMany(SaleDetail::class);
    }
    public function table(){
        return $this->belongsTo(Table::class);

    }
}
