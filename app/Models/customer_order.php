<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_order extends Model
{
    use HasFactory;
    protected $table = 'customer_orders';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
