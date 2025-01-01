<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\activity_log;
use App\Models\itemredeen;
use App\Models\customer;
use App\Models\customeritemredeen;
use Illuminate\Validation\Rule;

class pointRedeenController extends Controller
{
        //get all list item product
        public function index()
        {
            $itemredeen = itemredeen::where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get();
    
            return view('pointredeen.index',['itemredeen' => $itemredeen]);
        }//end method

            //create new item page
    public function create()
    {
        return view('pointredeen.create');
    }//end method

    // store new Item data
    public function store(Request $request)
    {
        $user_email =auth()->user()->email;

        // validated new items data 
        $validated = $request->validate([
            
            'name' => ['required','string',Rule::unique('itemredeens')->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'point' => 'required|integer',
            'description' => 'required|string',
            
        ]);

        
        //store data to database 
        $item = new itemredeen;
        $item->name = $validated['name'];
        $item->point = $validated['point'];
        $item->description = $validated['description'];
        $item->user_email = auth()->user()->email;
        $item->save();

        activity_log::addActivity('Add New Redeem Item',' add new item Redeem '.$validated['name'].' into system');

        return redirect(route('pointredeen'))->with('success','add new item redeem, success make new items '.$validated['name']);
        
    }//end method

        //edit items page
        public function edit(Request $request)
        {
            $items = itemredeen::find($request->input('id'));// id items input
    
            return view('pointredeen.edit',['items'=>$items]);
        }//end method
    
        //view items page
        public function view(Request $request)
        {
            $items = itemredeen::find($request->input('id'));// id items input
    
            return view('pointredeen.view',['items'=>$items]);
        }//end method

        public function status(Request $request)
        {
            $validated = $request->validate([
                'id' => 'required',
            ]);
    
            $item = itemredeen::find($request->input('id'));
    
            if($item->status == true)
            {
                $item->status = false;
                $item->save();
                
                activity_log::addActivity('change status',' change status item redeen to deactive');
                return redirect(route('pointredeen.edit').'?id='.$request->input('id'))->with('success','item is deactive');
            }
            else
            {
                $item->status = true;
                $item->save();
    
                activity_log::addActivity('change status',' change status item redeen to active back');
                return redirect(route('pointredeen.edit').'?id='.$request->input('id'))->with('success','item is active back');
            }
    
            return back();
        }//end method

                    //update item data 
    public function update(Request $request)
    {
        $user_email =auth()->user()->email;

        // validate data item update base rule
        $validated = $request->validate([
            'id' => 'required',
            'name' => ['required','string',Rule::unique('itemredeens')->ignore( $request->input('id'))->where(function($query) use ($user_email)
            {
                return $query->where('user_email', $user_email); // Adjust as necessary
            })],
            'point' => 'required|integer',
            'descriptions' => 'required',
                        
        ]);

        //store data update to database
        $item = itemredeen::find($validated['id']);
        $item->name = $validated['name'];
        $item->point = $validated['point'];
        $item->description = $validated['descriptions'];
        $item->save();

        activity_log::addActivity('update details item redeen ',' change it details item redeen '.$validated['name']);

        return redirect(route('pointredeen.edit').'?id='.$validated['id'])->with('success','edit details item '.$validated['name']);

    }//end method

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $item = itemredeen::find($request->input('id'));

        $item->delete();

        activity_log::addActivity('delete item redeem',' remove '.$item->name.' item redeem from list');

        return redirect(route('pointredeen'));
    }//end method


    public function customer_redeem(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $customer = '';

        $items = itemredeen::find($request->input('id'));

        if($request->has('id_cust'))
        {
            $customer = customer::find($request->input('id'));
        }

        return view('pointredeen.customer_redeem',['request'=>$request,'items'=>$items, 'customer'=>$customer]);
    }//end method

    public function search_customer(Request $request)
    {
        //get all list custmer data
        $customer = customer::list_by_email(auth()->user()->email);

        return view('pointredeen.search_customer',['request'=>$request,'customer'=>$customer]);
    }//end method

    public function redeen(Request $request)
    {
        $validated = $request->validate([
            'item_status' => 'accepted',
            'id' => 'required',
            'id_cust' => 'required',
            'name_cust' => 'required',
            'email_cust' => 'required',
            'phone_cust' => 'required',
            'point_customer' => 'required|gte:item_point',
        ]);

        $customer = customer::find($validated['id_cust']);
        $items = itemredeen::find($validated['id']);

        if($customer->point <= $items->point)
        {
            return redirect(route('pointredeen.customer_redeem').'?id='.$validated['id'])->with('error',$customer->name.' point is not enough to redeem');
        }

        $customeritemredeen = new customeritemredeen;
        $customeritemredeen->name = $customer->name;
        $customeritemredeen->email = $customer->email;
        $customeritemredeen->phone = $customer->phone;
        $customeritemredeen->ic = $customer->ic;
        $customeritemredeen->name_item = $items->name;
        $customeritemredeen->description_item = $items->description;
        $customeritemredeen->point = $items->point;
        $customeritemredeen->id_customer = $validated['id_cust'];
        $customeritemredeen->user_email = auth()->user()->email;
        $customeritemredeen->save();

        $customer->point = $customer->point - $items->point;
        $customer->save();

        activity_log::addActivity('redeem item customer',' redeem item '.$items->name.' customer '.$customer->name.'');

        return redirect(route('pointredeen.customer_redeem').'?id='.$validated['id'])->with('success',$customer->name.'  redeem pont items '.$items->name);

    }//end method

}//end class
