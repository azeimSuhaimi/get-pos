<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'users';
     protected $primaryKey = 'id';
     protected $keyType = 'string';
     public $timestamps = true;

     
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function update_last_login($email)
    {
            // get date today for bill 
            $now = Carbon::now();
            $date = $now->format('d-m-Y');
            $time = $now->format('H:i:s');

            $user = user::where('email',$email)->first();
            $user->last_login = $now;
            $user->save();

            return true;
    }//end method

    public static function add_user($name,$email,$phone,$ic)
    {
        $now = Carbon::now();// get date today
        
        //store data to database 
        $user = new user;
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->ic = $ic;
        $user->password = Hash::make($ic);
        $user->date_register = $now;
        $user->toyyip_key = Crypt::encryptString('');
        $user->toyyip_category = Crypt::encryptString('');
        $user->key = Str::random(32);
        $user->save();

        return $user;

    }//end method

}//end class
