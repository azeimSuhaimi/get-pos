<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class toyyibpay extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $table = 'toyyibpays';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
