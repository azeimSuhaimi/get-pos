<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\customer_order;
use Illuminate\Support\Carbon;
use App\Models\activity_log;

class customer_orderController extends Controller
{
    public function index(Request $request)
    {
        if($request->input('date') != null)
        {
            $validated = $request->validate([
                'date' => 'required|date_format:Y-m', // Ensure the format is 'YYYY-MM'
            ]);

            $customer_order = customer_order::customer_order_list_by_date(auth()->user()->id, $validated['date']);
            
            $data = [
                'request' => $request,
                'customer_order' => $customer_order,
                'date' => $validated['date']
            ];
        }
        else
        {
            $customer_order = customer_order::customer_order_all_list(auth()->user()->id);
            
            $data = [
                'request' => $request,
                'customer_order' => $customer_order,
                'date' => null
            ];
        }

        return view('customer_order.index',$data);

    }//end method

    public function create()
    {
        return view('customer_order.create');
    }//end method


    // store new  data
    public function store(Request $request)
    {
        

        // validated new  data 
        $validated = $request->validate([
            
            'name' => 'required|string',
            'email' => 'required',
            'phone' => 'required',
            'item' => 'required',
            'remark' => 'nullable',
            
        ]);

        //store data to database 
        customer_order::add_customer_order($validated['name'],$validated['email'],$validated['phone'],$validated['item'],$validated['remark']);

        activity_log::addActivity('Add New Customer Order',' add new Customer Order '.$validated['name'].' ');

        return redirect(route('customer_order'))->with('success','add new customer order '.$validated['name']);
        
    }//end method

    public function update_contact(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        customer_order::update_contact($validated['id']);
        
        activity_log::addActivity('update status contact',' update status contact ');
            


        return back()->with('success','update customer order contact ');
    }//end method

    public function update_status(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        customer_order::update_pickup($validated['id']);

        activity_log::addActivity('update status pick up',' update status pick up ');
            


        return back()->with('success','update customer order status ');
    }//end method


        
    public function remove (Request $request)
    {
        // validation all input expense 
        $validated = $request->validate([
            'id' => 'required',
        ]);

        customer_order::delete_customer_order($validated['id']);

        activity_log::addActivity('remove  customer order ',' remove customer order ');

        return back()->with('success','remove customer order  ');

    }//end method

}//end class
