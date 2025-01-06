<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quickorder extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'quickorders';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
