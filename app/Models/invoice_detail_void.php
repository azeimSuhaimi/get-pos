<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoice_detail_void extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'invoice_detail_voids';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
