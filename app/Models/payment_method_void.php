<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class payment_method_void extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'payment_method_voids';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
