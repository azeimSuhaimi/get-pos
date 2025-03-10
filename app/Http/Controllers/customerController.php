<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\customer;

use App\Models\activity_log;
use Illuminate\Http\Request;
use App\Models\purchase_detail;
use Illuminate\Validation\Rule;
use App\Models\customeritemredeen;
use App\Models\invoice_detail;

class customerController extends Controller
{
    //get all list custmer member
    public function index()
    {
        //get all list custmer data
        $customer = customer::list_by_id(auth()->user()->id);

        return view('customer.index',['customer' => $customer]);
    }//end method

    
    public function create()
    {
        return view('customer.create');
    }//end method

    public function store(Request $request)
    {
        $user_id =auth()->user()->id;
        //validation data input
        $validated = $request->validate([
            
            'name' => 'required|string',
            'address' => 'nullable|string',
            'phone' => ['required','numeric',Rule::unique('customers')->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })],
            'email' => ['required','email',Rule::unique('customers')->where(function($query) use ($user_id)
        {
            return $query->where('user_id', $user_id); // Adjust as necessary
        })],
            'ic' => ['required','numeric',Rule::unique('customers')->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })],
        ]);

        //store data to database 
        $customer = customer::add_customer($validated['name'],$validated['address'],$validated['phone'],$validated['email'],$validated['ic']);

        activity_log::addActivity('Add New Customer ',' Registeer new member to '.$validated['name']);

        return back()->with('success','Add new member '.$validated['name']);
    }// end method

        //edit customer page
        public function edit(Request $request)
        {
            $customer = customer::find($request->input('id'));// id customer input
    
            return view('customer.edit',['customer'=>$customer]);
        }//end method
    
        //view customer page
        public function view(Request $request)
        {
            $customer = customer::find($request->input('id'));// id customer input
    
            return view('customer.view',['customer'=>$customer]);
        }//end method

            //update employee data 
    public function update(Request $request)
    {
        $user_id =auth()->user()->id;

        // validate data employee update base rule
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required|string',
            'email' =>['required','email',Rule::unique('customers')->ignore( $request->input('id'))->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })],
            'phone' => ['required','numeric',Rule::unique('customers')->ignore( $request->input('id'))->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })],
            'ic' =>['required','numeric',Rule::unique('customers')->ignore( $request->input('id'))->where(function($query) use ($user_id)
            {
                return $query->where('user_id', $user_id); // Adjust as necessary
            })] ,
            'address' => 'required',
            
            
        ]);

        //store data update to database
        $customer = customer::update_customer($validated['id'],$validated['name'],$validated['email'],$validated['phone'],$validated['ic'],$validated['address']);

        activity_log::addActivity('update details customer ',' change it details customer '.$validated['name']);

        return redirect(route('customer.edit').'?id='.$validated['id'])->with('success','edit details customer '.$validated['name']);

    }//end method

    //get all list custmer member purchase
    public function purchase_detail(Request $request)
    {
                // validate data employee update base rule
        $validated = $request->validate([
            'id_cust' => 'required',
        ]);

        //get all list custmer data
        $purchase_detail = purchase_detail::where('id_cust',$validated['id_cust'])->orderBy('created_at', 'desc')->get();
        $customeritemredeen = customeritemredeen::where('id_customer',$validated['id_cust'])->orderBy('created_at', 'desc')->get();
        $customer = customer::find($validated['id_cust']);

        return view('customer.purchase_detail',['purchase_detail' => $purchase_detail,'customer' => $customer,'customeritemredeen' => $customeritemredeen]);
    }//end method

    public function enter_member(Request $request)
    {
        $user_id =auth()->user()->id;

        // validate data employee update base rule
        $validated = $request->validate([
            'cust_phone' => 'required',
            'invoice_id' => 'required',
            'id' => 'required',
            
            
        ]);

        $invoice = invoice::where('invoice_id',$validated['invoice_id'])->where('user_id',$user_id)->first();

        if(!$invoice)
        {
            return redirect(route('customer.purchase.detail').'?id_cust='.$validated['id'])->with('error','invoice enter not exist '.$validated['invoice_id']);
        }

        if(!$invoice->phone_cust == null)
        {
            return redirect(route('customer.purchase.detail').'?id_cust='.$validated['id'])->with('error','invoice enter already have member '.$validated['invoice_id']);
        }




        $customer = customer::where('id',$validated['id'])->where('user_id',$user_id)->first();
        $customer->point += $invoice->subtotal;
        $customer->save();

        foreach(invoice_detail::where('invoice_id', $validated['invoice_id'])->get() as $row)
        {
            $purchase_detail = new purchase_detail;
            $purchase_detail->id_cust = $customer->id;
            $purchase_detail->invoice_id = $invoice->invoice_id;
            
            $purchase_detail->shortcode = $row->shortcode;
            $purchase_detail->name = $row->name;
            $purchase_detail->quantity = $row->quantity;
            $purchase_detail->price = $row->price;
            $purchase_detail->cost = $row->cost;
            $purchase_detail->discount = $row->discount;
            $purchase_detail->description = $row->description;
            $purchase_detail->user_id = $invoice->user_id;
            $purchase_detail->save();
        }

        $invoice->phone_cust = $customer->phone;
        $invoice->email_cust = $customer->email;
        $invoice->name_cust = $customer->name;
        $invoice->save();

        activity_log::addActivity('enter member on Invoice ',' enter invoice '.$validated['invoice_id']);

        return redirect(route('customer.purchase.detail').'?id_cust='.$validated['id'])->with('success','enter member to invoice '.$validated['invoice_id']);

    }//end method


}//end class
