<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class customer_order extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'customer_orders';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;

    public static function customer_order_all_list($id)
    {
        $customer_order = customer_order::where('user_id',$id)->orderBy('created_at', 'desc')->get();

        return $customer_order;
    }//end method

    public static function customer_order_list_by_date($id,$date)
    {
        $customer_order = customer_order::where('user_id',$id)->where('date_month', $date)->orderBy('created_at', 'desc')->get();

        return $customer_order;
    }//end method

    public static function add_customer_order($name,$email,$phone,$item,$remark)
    {
        $date_month = Carbon::now()->format('Y-m');

        //store data to database 
        $customer_order = new customer_order;
        $customer_order->name = $name;
        $customer_order->email = $email;
        $customer_order->phone = $phone;
        $customer_order->item = $item;
        $customer_order->remark = $remark;
        $customer_order->date_month =  $date_month;
        $customer_order->user_id = auth()->user()->id;
        $customer_order->save();

        return true;
    }//end method

    public static function update_contact($id)
    {
        $customer_order = customer_order::find($id);
    
        $customer_order->contact = true;
        $customer_order->save();

        return true;
    }//end method

    public static function update_pickup($id)
    {
        $customer_order = customer_order::find($id);
    
        $customer_order->status = true;
        $customer_order->contact = true;
        $customer_order->save();

        return true;
    }//end method

    public static function delete_customer_order($id)
    {
        $customer_order = customer_order::find($id);
        $customer_order->delete();
        return true;
    }//end method

}//end class
