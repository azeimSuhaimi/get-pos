<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class waste extends Model
{
    use HasFactory;

    protected $table = 'wastes';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;
}
