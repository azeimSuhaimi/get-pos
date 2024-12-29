<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customeritemredeen extends Model
{
    use HasFactory;
    protected $table = 'customeritemredeens';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
