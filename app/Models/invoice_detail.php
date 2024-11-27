<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_detail extends Model
{
    use HasFactory;
    protected $table = 'invoice_details';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
