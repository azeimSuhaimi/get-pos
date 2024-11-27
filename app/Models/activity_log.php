<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class activity_log extends Model
{
    use HasFactory;
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;

    public static function addActivity($activity,$details)
    {
        $now = Carbon::now();
        $date = $now->format('d-m-Y');
        $time = $now->format('H:i:s');
        $unixTimestamp = Carbon::now()->timestamp;
        $activity_log = new activity_log;

        $activity_log->activity = $activity;
        $activity_log->details = $details;
        $activity_log->date = $date;
        $activity_log->time = $time;
        $activity_log->unix_time = $unixTimestamp;
        $activity_log->user_email = auth()->user()->email;
        $activity_log->save();
        
    }

}
