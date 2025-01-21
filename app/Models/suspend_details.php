<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class suspend_details extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'suspend_details';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
