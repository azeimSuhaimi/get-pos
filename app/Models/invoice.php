<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
