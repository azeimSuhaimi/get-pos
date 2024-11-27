<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase_detail extends Model
{
    use HasFactory;
    protected $table = 'purchase_details';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
