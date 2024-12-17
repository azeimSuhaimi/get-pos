<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\customer;
use App\Models\activity_log;
use App\Models\purchase_detail;

class customerController extends Controller
{
    //get all list custmer member
    public function index()
    {
        //get all list custmer data
        $customer = customer::where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get();

        return view('customer.index',['customer' => $customer]);
    }//end method

    
    public function create()
    {
        return view('customer.create');
    }//end method

    public function store(Request $request)
    {
        $user_email =auth()->user()->email;
        //validation data input
        $validated = $request->validate([
            
            'name' => 'required|string',
            'address' => 'nullable|string',
            'phone' => ['required','numeric',Rule::unique('customers')->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'email' => ['required','email',Rule::unique('customers')->where(function($query) use ($user_email)
        {
            return $query->where('user_email', $user_email); // Adjust as necessary
        })],
            'ic' => ['required','numeric',Rule::unique('customers')->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
        ]);

        //store data to database 
        $customer = new customer;
        $customer->name = $validated['name'];
        $customer->address = $validated['address'];
        $customer->phone = $validated['phone'];
        $customer->email = $validated['email'];
        $customer->ic = $validated['ic'];
        $customer->point = 0;
        $customer->user_email = auth()->user()->email;
        $customer->save();

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
        $user_email =auth()->user()->email;

        // validate data employee update base rule
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required|string',
            'email' =>['required','email',Rule::unique('customers')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'phone' => ['required','numeric',Rule::unique('customers')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'ic' =>['required','numeric',Rule::unique('customers')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })] ,
            'address' => 'required',
            
            
        ]);
        //dd($request->all());
        //store data update to database
        $customer = customer::find($validated['id']);
        $customer->name = $validated['name'];
        $customer->email = $validated['email'];
        $customer->phone = $validated['phone'];
        $customer->ic = $validated['ic'];
        $customer->address = $validated['address'];
        $customer->save();

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
            $purchase_detail = purchase_detail::where('id_cust',$validated['id_cust'])->get();
            $customer = customer::find($validated['id_cust']);
    
            return view('customer.purchase_detail',['purchase_detail' => $purchase_detail,'customer' => $customer]);
        }//end method

}//end class
