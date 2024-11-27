<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_method_void extends Model
{
    use HasFactory;
    protected $table = 'payment_method_voids';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
