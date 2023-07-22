<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public $fillable = ['name'];
    use HasFactory;
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
