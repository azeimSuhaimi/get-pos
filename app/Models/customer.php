<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class customer extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;

    public static function list_by_id($id)
    {
        $customer = customer::where('user_id',$id)->orderBy('created_at','desc')->get();

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
        $customer->user_id = auth()->user()->id;
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
