<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class toyyibpay extends Model
{
    use HasFactory;
    
    protected $table = 'toyyibpays';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
