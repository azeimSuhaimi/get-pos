<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Models\quickorder;
use App\Models\quickorder_detail;
use App\Models\company;
use App\Models\item;

class quickorderController extends Controller
{
    public function index(Request $request)
    {
        Cart::destroy();
        $company = company::all();// get all suspend list
        return view('quickorder.index',['company'=>$company]);
    }//end method

    public function list(Request $request)
    {
        $validated = $request->validate([
            
            'user_email' => 'required|email',
        ]);

        if(!company::where('user_email',$validated['user_email'])->first())
        {
            return redirect(route('quick'));
        }

        $item = item::where('user_email',$validated['user_email'])->where('quickorder_status','true')->get();// get all suspend list
        return view('quickorder.list',['item'=>$item,'validated'=>$validated]);
    }//end method

        // add item to cart for list item selected
        public function add_item(Request $request)
        {
            // validation all input item add
            $validated = $request->validate([
                
                'shortcode' => 'required',
                'user_email' => 'required|email',
            ]);

            if(!company::where('user_email',$validated['user_email'])->first())
            {
                return redirect(route('quick'));
            }
    
            $item = item::where('shortcode',$validated['shortcode'])->where('user_email',$validated['user_email'])->first();
    
            if($item === null)
            {
                
                return redirect(route('quick.list').'?user_email='.$validated['user_email'])->with('error','item enter not exist in system');
            }
            else
            {
                if($item->quantity < 1)
                {
                    return redirect(route('quick.list').'?user_email='.$validated['user_email'])->with('error','item enter quantity is empty in system');
                }
                else
                {
                    //add to cart item select
                    Cart::add($item->shortcode,$item->name, 1, $item->price,['cost' => $item->cost,'description' => $item->description, 'category' => $item->category, 'remark' => '']);
                    return redirect(route('quick.list').'?user_email='.$validated['user_email'])->with('success','item enter added');
                }
    
            }
    
            //return redirect()->back();
    
        }//end method

}//end class
