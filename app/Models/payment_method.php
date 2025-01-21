<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class payment_method extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
