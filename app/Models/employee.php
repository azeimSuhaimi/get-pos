<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class employee extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
