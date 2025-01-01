<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Carbon;

class test extends Model
{
    use HasFactory, SoftDeletes;

    public static function ListByEmail($email)
    {
        $customer = customer::where('user_email',$email)->orderBy('created_at','desc')->get();

        return $customer;
    }//end method

    public static function customer_order_all_list($email)
    {
        $customer_order = customer_order::where('user_email',$email)->orderBy('created_at', 'desc')->get();

        return $customer_order;
    }//end method

    public static function customer_order_list_by_date($email,$date)
    {
        $customer_order = customer_order::where('user_email',$email)->where('date_month', $date)->orderBy('created_at', 'desc')->get();

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
        $customer_order->user_email = auth()->user()->email;
        $customer_order->save();

        return true;
    }//end method

    public static function delete_customer_order($id)
    {
        $customer_order = customer_order::find($id);
        if(!$customer_order)
        {
            return response()->json(['messege' => 'data not found']);
            return 'tiada data '.$id ;
        }

        if($customer_order->user_email != auth()->user()->email)
        {
            return response()->json(['messege' => 'you are not unauthorize']);
        }
        $customer_order->delete();
        return true;
    }//end method

    public static function update_pickup($id)
    {
        $customer_order = customer_order::find($id);

        if(!$customer_order)
        {
            return response()->json(['messege' => 'data not found']);
            return 'tiada data '.$id ;
        }

        if($customer_order->user_email != auth()->user()->email)
        {
            return response()->json(['messege' => 'you are not unauthorize']);
        }

        $customer_order->status = true;
        $customer_order->contact = true;
        $customer_order->save();

        return true;
    }//end method

    public static function list_all_including_softdelete($id)
    {
        $items = item::withTrashed()->where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get();
        if(!$customer_order)
        {
            return response()->json(['messege' => 'data not found']);
            return 'tiada data '.$id ;
        }

        if($customer_order->user_email != auth()->user()->email)
        {
            return response()->json(['messege' => 'you are not unauthorize']);
        }
        $customer_order->delete();
        return $items;
    }//end method

    public static function list_softdelete_only($id)
    {
        $items = item::onlyTrashed()->where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get();;
        if(!$customer_order)
        {
            return response()->json(['messege' => 'data not found']);
            return 'tiada data '.$id ;
        }

        if($customer_order->user_email != auth()->user()->email)
        {
            return response()->json(['messege' => 'you are not unauthorize']);
        }
        $customer_order;
        return $items;
    }//end method

}//end class
