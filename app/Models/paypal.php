<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paypal extends Model
{
    use HasFactory;
    protected $table = 'paypals';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
