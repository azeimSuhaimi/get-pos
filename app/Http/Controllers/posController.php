<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Models\item;
use App\Models\suspend;
use App\Models\suspend_details;
use App\Models\activity_log;
use Illuminate\Support\Carbon;

class posController extends Controller
{
        
    public function index()
    {
        $suspend = suspend::all();// get all suspend list
        return view('pos.index',['suspend'=>$suspend]);
    }//end method

    // add item to cart for list item selected
    public function add_item(Request $request)
    {
        // validation all input item add
        $validated = $request->validate([
            
            'shortcode' => 'required',
        ]);

        $item = item::where('shortcode',$validated['shortcode'])->where('user_email',auth()->user()->email)->first();

        if($item === null)
        {
            
            return redirect()->back()->with('error','item enter not exist in system');
        }
        else
        {
            if($item->quantity < 1)
            {
                return redirect()->back()->with('error','item enter quantity is empty in system');
            }
            else
            {
                //add to cart item select
                Cart::add($item->shortcode,$item->name, 1, $item->price,['cost' => $item->cost,'description' => $item->description, 'category' => $item->category, 'remark' => '']);
                return redirect(route('pos'));
            }

        }

        return redirect()->back();

    }//end method

    public function search_item()
    {
        $item = item::where('user_email',auth()->user()->email)->get(); // get all items list
        return view('pos.searching',['items'=>$item]);
    }//end method
    public function update_quantity_page(Request $request)
    {
        // check id input exist
        $validated = $request->validate([
    
            'rowid' => 'required',  // Ensure rowid exists in the cart
        ]);

        $data = [
            
            'rowid' => cart::get($validated['rowid']),
        ];

        return view('pos.update_price_quantity',$data);
    }//end method

    //update quantity items selected in cart
    public function update_quantity(Request $request)
    {
        if($request->has('id')) // check id required
        {
            if($request->input('qty') > 0)//enter not less zero
            {
                if($request->has('rowid'))
                {
                    $id = $request->input('id'); // items id select
                    $quantity = $request->input('qty'); // quantity update 
                    $rowId = $request->input('rowid');// id in row cart select
    
                    Cart::update($rowId, $quantity); // update the quantity items
    
                    return redirect(route('pos'));
                }

            }
            return redirect()->back()->with('error', 'quantity cannot negetif added have a problem!!!');
        }

        return redirect()->back()->with('error', 'Item added have a problem.');
    }//emd method

    public function update_price_page(Request $request)
    {
        // check id input exist
        $validated = $request->validate([
    
            'rowid' => 'required',  // Ensure rowid exists in the cart
        ]);

        $data = [
            
            'rowid' => cart::get($validated['rowid']),
        ];

        return view('pos.update_price_quantity',$data);
    }//end method

    //update price items selected in cart
    public function update_price(Request $request)
    {
        if($request->has('id')) // check id required
        {
            if($request->input('price') > 0)//enter not less zero
            {
                if($request->has('rowid'))
                {
                    $id = $request->input('id'); // items id select
                    $price = $request->input('price'); // quantity update 
                    $rowId = $request->input('rowid');// id in row cart select
    
                    Cart::update($rowId, ['price' => $price]); // update the quantity items
    
                    activity_log::addActivity('change price item ',' change it price item '.Cart::get($rowId)->name);
                    return redirect(route('pos'));
                }


            }
            return redirect()->back()->with('error', 'price cannot negetif added have a problem!!!');
        }

        return redirect()->back()->with('error', 'Item added have a problem.');
    }//emd method

    //remove item in cart
    public function item_remove(Request $request)
    {
        if($request->has('rowid'))// check row id in cart
        {
            $rowId = $request->input('rowid'); // input row id in cart

            Cart::remove($rowId); // remove items selected

            return redirect()->back()->with('success', 'items removed from cart.');
        }

        return redirect()->back()->with('error', 'Item remove have a problem.');
    }//end method

    // remove all item in cart
    public function remove_all(Request $request)
    {
        Cart::destroy();
        return redirect(route('pos'))->with('success', ' new sale created.');
    }//end method

    // suspend all items select in cart 
    public function suspend(Request $request)
    {
        // check in cart exist or not
        if($request->input('qty') > 0)//enter not less zero
        {
            
            $bill_id = Carbon::now()->timestamp; // get timestamp for bill id

            // store data in suspend bill
            $suspend = new suspend;
            $suspend->bill_id = $bill_id;
            $suspend->user_email = auth()->user()->email;
            $suspend->total = Cart::total();
            $suspend->save();

            // store list items in suspend bill
            foreach(Cart::content() as $row)
            {
                $suspend = new suspend_details;
                $suspend->bill_id = $bill_id;
                $suspend->shortcode = $row->id;
                $suspend->name = $row->name;
                $suspend->quantity = $row->qty;
                $suspend->price = $row->price;
                $suspend->cost = $row->options->cost;
                $suspend->description = $row->options->description;
                $suspend->category = $row->options->category;
                $suspend->remark = $row->options->remark;
                $suspend->save();
            }

            Cart::destroy(); // remove all items in cart

            return redirect()->back()->with('success', 'item suspend now!!!');
        }
        return redirect()->back()->with('error', 'item cannot empty  to suspend!!!');
    }//end method

    // view list suspend bill 
    public function suspend_view(Request $request)
    {
        $suspend = suspend::where('user_email',auth()->user()->email)->orderBy('created_at','desc')->get(); // get all list suspend bill
        $u = 0;
        foreach($suspend as $row)
        {
            $u += 1;
        }


        if(Cart::total() > 0)
        {
            return redirect(route('pos'))->with('error', ' please clear all item first or create new sale.');
        }
        else
        {
            if($u >= 1)
            {
                return view('pos.unsuspend',['suspend'=>$suspend]);
            }
            else
            {
                return redirect(route('pos'))->with('error', ' suspend is empty.');
            }
        }

        return back();

        
    }//end method

    //unsuspend bill in suspend bill 
    public function unsuspend(Request $request)
    {
        // check id input exist
        $validated = $request->validate([
            
            'id' => 'required',
        ]);

        $suspend = suspend::find($validated['id']); // find suspend bill based id 
        $suspend_details = suspend_details::where('bill_id',$suspend->bill_id)->get();// get list items on suspend bill 

        // remove first cart if have before restore suspend
        Cart::destroy();

        // retore back bill in unsuspend
        foreach($suspend_details as $row)
        {
            //add to cart
            Cart::add($row->shortcode, $row->name, $row->quantity, $row->price,['cost' => $row->cost,'description' => $row->description, 'category' => $row->category, 'remark' => $row->remark]);

            $row->delete(); // delete item in suspend table
        }

        $suspend->delete(); // deldete bill in suspend table
        

        return redirect(route('pos'));

    }//end method

    public function add_remark(Request $request)
    {
        // check id input exist
        $validated = $request->validate([
    
            'rowid' => 'required',  // Ensure rowid exists in the cart
        ]);

        $data = [
            'rowid' => $validated['rowid'],
            'remark' => cart::get($validated['rowid']),
        ];

        return view('pos.add_remark',$data);
    }//end method

    public function update_remark(Request $request)
    {
        $validated = $request->validate([
    
            'rowid' => 'required',  // Ensure rowid exists in the cart
            'remark' => 'required',           // Validate remark
            'cost' => 'required',                    // Validate cost
            'description' => 'nullable',      // Validate description
            'category' => 'required',        // Validate category
        ]);

        // Get the current cart item
        $cartItem = Cart::get($validated['rowid']);
        
        if (!$cartItem) {
            return redirect()->back()->with('error', 'Item not found in cart.');
        }

        // Merge the updated fields into the current options
        $updatedOptions =  [
            'remark' => $validated['remark'],
            'cost' => $validated['cost'],
            'description' => $validated['description'],
            'category' => $validated['category'],
        ];

        //Cart::update($validated['rowid'], ['remark' => $validated['remark']]);

        // Update the cart item with the merged options
        Cart::update($validated['rowid'], [
            'options' => $updatedOptions
        ]);

        return redirect(route('pos'))->with('success', 'remark add to items');
    }//end method

}//end class
