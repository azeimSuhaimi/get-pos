<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;

use App\Models\quickorder;
use App\Models\quickorder_detail;
use App\Models\company;
use App\Models\item;
use App\Mail\quickordermail;

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

        public function view(Request $request)
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

            $item = item::where('user_email',$validated['user_email'])->where('shortcode',$validated['shortcode'])->first();// get all suspend list
            return view('quickorder.view',['item'=>$item,'validated'=>$validated]);
        }//end method

        public function cart_view(Request $request)
        {
            // validation all input item add
            $validated = $request->validate([
    
                
                'user_email' => 'required|email',
            ]);

            if(!company::where('user_email',$validated['user_email'])->first())
            {
                return redirect(route('quick'));
            }

            
            return view('quickorder.cart_view',['validated'=>$validated]);
        }//end method

        public function cart_checkout(Request $request)
        {
            $validated = $request->validate([
    
                'email' => 'required|email',
                'user_email' => 'required|email',
            ]);

            if(Cart::total() <= 0)
            {
                return redirect()->back()->with('error', 'item cannot empty  to create quick order!!!');
            }

            $barcode = Carbon::now()->timestamp; // get timestamp for bill id

            // store payment cash sales 
            $quickorder = new quickorder;
            $quickorder->barcode = $barcode;
            $quickorder->user_email = $validated['user_email'];
            $quickorder->customer_email = $validated['email'];
            $quickorder->subtotal = Cart::subtotal();
            $quickorder->tax = round(Cart::tax() * 20)/ 20;
            $quickorder->total = round(Cart::total() * 20)/ 20;
            $quickorder->status = true;
            $quickorder->save();

                    // store items list for bill
        foreach(Cart::content() as $row)
        {

            //store data to list item buy
            $quickorder_detail = new quickorder_detail;
            $quickorder_detail->barcode = $barcode;
            $quickorder_detail->shortcode = $row->id;
            $quickorder_detail->name = $row->name;
            $quickorder_detail->quantity = $row->qty;
            $quickorder_detail->price = $row->price;
            $quickorder_detail->cost = $row->options->cost;
            $quickorder_detail->description = $row->options->description;
            $quickorder_detail->category = $row->options->category;
            $quickorder_detail->remark = $row->options->remark;
            
            $quickorder_detail->save();
        }//end loop product details

        Cart::destroy();// remove all items in cart 

        $company = company::where('user_email',$validated['user_email'])->first();
        
        $datas = [
            
            'company' => $company,
            'quickorder' => quickorder::firstWhere('barcode', $barcode),
            'quickorder_detail' => quickorder_detail::where('barcode', $barcode)->get(),
        ];

        Mail::to($validated['email'])->send(new quickordermail( $datas));
        return redirect(route('quick.list').'?user_email='.$validated['user_email'])->with('success','send quick order to to email '.$validated['email']);

        }//end method

}//end class
