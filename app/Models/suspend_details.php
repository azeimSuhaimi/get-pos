<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suspend_details extends Model
{
    use HasFactory;
    protected $table = 'suspend_details';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
