<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;

    public static function list_by_email($email)
    {
        $customer = customer::where('user_email',$email)->orderBy('created_at','desc')->get();

        return $customer;
    }//end method

    public static function add_customer($name,$address,$phone,$email,$ic)
    {
        //store data to database 
        $customer = new customer;
        $customer->name = $name;
        $customer->address = $address;
        $customer->phone = $phone;
        $customer->email = $email;
        $customer->ic = $ic;
        $customer->point = 0;
        $customer->user_email = auth()->user()->email;
        $customer->save();

        return true;
    }//end method

    public static function update_customer($id,$name,$email,$phone,$ic,$address)
    {
        $customer = customer::find($id);
        $customer->name = $name;
        $customer->email = $email;
        $customer->phone = $phone;
        $customer->ic = $ic;
        $customer->address = $address;
        $customer->save();

        return true;
    }//end method
}//end class
