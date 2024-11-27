<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suspend extends Model
{
    use HasFactory;
    protected $table = 'suspends';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
