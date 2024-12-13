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
            
            // Get the selected month and year from the input
            $monthYear  =  $validated['date'];


            $customer_order = customer_order::where('user_email',auth()->user()->email)->where('date_month', $validated['date'])->orderBy('created_at', 'desc')->get();
            
            $data = [
                'request' => $request,
                'customer_order' => $customer_order,
                'date' => $validated['date']
            ];
        }
        else
        {
            $customer_order = customer_order::where('user_email',auth()->user()->email)->orderBy('created_at', 'desc')->get();
            
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
            $user_email =auth()->user()->email;
    
            // validated new  data 
            $validated = $request->validate([
                
                'name' => 'required|string',
                'email' => 'required',
                'phone' => 'required',
                'item' => 'required',
                'remark' => 'nullable',
                
            ]);
    
            $date_month = Carbon::now()->format('Y-m');
            echo $date_month;

            //store data to database 
            $customer_order = new customer_order;
            $customer_order->name = $validated['name'];
            $customer_order->email = $validated['email'];
            $customer_order->phone = $validated['phone'];
            $customer_order->item = $validated['item'];
            $customer_order->remark = $validated['remark'];
            $customer_order->date_month =  $date_month;
            $customer_order->user_email = auth()->user()->email;
            $customer_order->save();
    
    
            activity_log::addActivity('Add New Customer Order',' add new Customer Order '.$validated['name'].' ');
    
            return redirect(route('customer_order'))->with('success','add new customer order '.$validated['name']);
            
        }//end method

        public function update_contact(Request $request)
        {
            $validated = $request->validate([
                'id' => 'required',
            ]);
    
            $customer_order = customer_order::find($validated['id']);
    
            $customer_order->contact = true;
            $customer_order->save();
            
            activity_log::addActivity('update status contact',' update status contact '.$customer_order->name);
                

    
            return back()->with('success','update customer order contact '.$customer_order->name);
        }//end method

        public function update_status(Request $request)
        {
            $validated = $request->validate([
                'id' => 'required',
            ]);
    
            $customer_order = customer_order::find($validated['id']);
    
            $customer_order->status = true;
            $customer_order->contact = true;
            $customer_order->save();
            
            activity_log::addActivity('update status pick up',' update status pick up '.$customer_order->name);
                

    
            return back()->with('success','update customer order status '.$customer_order->name);
        }//end method


        
    public function remove (Request $request)
    {

            // validation all input expense 
            $validated = $request->validate([
                'id' => 'required',
            ]);

            $customer_order = customer_order::find($validated['id']);
 
            activity_log::addActivity('remove  customer order ',' remove customer order '.$customer_order->name);
            $customer_order->delete();


        return back()->with('success','remove customer order  '.$customer_order->name);

    }//end method

}//end class
