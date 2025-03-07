<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\company;
use App\Models\purchase_detail;
use App\Models\invoice;
use App\Models\customer;
use App\Models\invoice_detail;
use App\Models\toyyibpay;
use App\Models\quickorder;
use App\Mail\quickordermail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\quickorder_detail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Mail\toyyibpay_link;

class quickorderController extends Controller
{
    public function index(Request $request)
    {
        Cart::destroy();
        $company = company::all();// get all suspend list
        return view('quickorder.index',['company'=>$company]);
    }//end method

    public function list_company(Request $request)
    {
        
        $company = company::where('shop_name','LIKE','%'.$request->input('query').'%')->get();// get all suspend list
        return  $company;

        //return response()->json(['result' => $company]);
        //return view('quickorder.index',['company'=>$company]);
    }//end method

    public function list(Request $request)
    {
        $validated = $request->validate([
            
            'user_id' => 'required',
        ]);

        if(!company::where('user_id',$validated['user_id'])->first())
        {
            return redirect(route('quick'));
        }

        $item = item::where('user_id',$validated['user_id'])->where('status',true)->where('quickorder_status','true')->get();// get all suspend list
        return view('quickorder.list',['item'=>$item,'validated'=>$validated]);
    }//end method

        // add item to cart for list item selected
        public function add_item(Request $request)
        {
            // validation all input item add
            $validated = $request->validate([
                
                'shortcode' => 'required',
                'user_id' => 'required',
            ]);

            if(!company::where('user_id',$validated['user_id'])->first())
            {
                return redirect(route('quick'));
            }
    
            $item = item::where('shortcode',$validated['shortcode'])->where('user_id',$validated['user_id'])->first();
    
            if($item === null)
            {
                
                return redirect(route('quick.list').'?user_id='.$validated['user_id'])->with('error','item enter not exist in system');
            }
            else
            {
                if($item->quantity < 1)
                {
                    return redirect(route('quick.list').'?user_id='.$validated['user_id'])->with('error','item enter quantity is empty in system');
                }
                else
                {
                    //add to cart item select
                    $price = $item->price - ($item->price * $item->discount / 100);
                    Cart::add($item->shortcode,$item->name, 1, $price,['cost' => $item->cost,'description' => $item->description, 'category' => $item->category, 'remark' => '', 'discount' => $item->discount]);
                    return redirect(route('quick.list').'?user_id='.$validated['user_id'])->with('success','item enter added');
                }
    
            }
    
            //return redirect()->back();
    
        }//end method

        public function view(Request $request)
        {
            // validation all input item add
            $validated = $request->validate([
    
                'shortcode' => 'required',
                'user_id' => 'required',
            ]);

            if(!company::where('user_id',$validated['user_id'])->first())
            {
                return redirect(route('quick'));
            }

            $item = item::where('user_id',$validated['user_id'])->where('shortcode',$validated['shortcode'])->first();// get all suspend list
            return view('quickorder.view',['item'=>$item,'validated'=>$validated]);
        }//end method

        public function cart_view(Request $request)
        {
            // validation all input item add
            $validated = $request->validate([
    
                
                'user_id' => 'required',
            ]);

            if(!company::where('user_id',$validated['user_id'])->first())
            {
                return redirect(route('quick'));
            }

            
            return view('quickorder.cart_view',['validated'=>$validated]);
        }//end method

        public function cart_checkout(Request $request)
        {
            $validated = $request->validate([
    
                
                'email' => 'required|email',
                'user_id' => 'required',
            ]);

            if(Cart::total() <= 0)
            {
                return redirect()->back()->with('error', 'item cannot empty  to create quick order!!!');
            }

            $barcode = Carbon::now()->timestamp; // get timestamp for bill id

            // store payment cash sales 
            $quickorder = new quickorder;
            $quickorder->barcode = $barcode;
            $quickorder->user_id = $validated['user_id'];
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
                $quickorder_detail->discount = $row->options->discount;
                $quickorder_detail->description = $row->options->description;
                $quickorder_detail->category = $row->options->category;
                $quickorder_detail->remark = $row->options->remark;
                
                $quickorder_detail->save();
            }//end loop product details

            Cart::destroy();// remove all items in cart 

            $company = company::where('user_id',$validated['user_id'])->first();
            
            $datas = [
                
                'company' => $company,
                'quickorder' => quickorder::firstWhere('barcode', $barcode),
                'quickorder_detail' => quickorder_detail::where('barcode', $barcode)->get(),
            ];

            Mail::to($validated['email'])->send(new quickordermail( $datas));
            return redirect(route('quick.list').'?user_id='.$validated['user_id'])->with('success','send quick order to to email '.$validated['email']);

        }//end method

            //remove item in cart
    public function item_remove(Request $request)
    {
        $validated = $request->validate([
    
            
            'user_id' => 'required',
        ]);

        if($request->has('rowid'))// check row id in cart
        {
            $rowId = $request->input('rowid'); // input row id in cart

            Cart::remove($rowId); // remove items selected

            return redirect(route('quick.cart.view').'?user_id='.$validated['user_id'])->with('success', 'items removed from cart.');
        }

        return redirect(route('quick.cart.view').'?user_id='.$validated['user_id'])->with('error', 'Item remove have a problem.');
    }//end method

    public function add_remark(Request $request)
    {
        // check id input exist
        $validated = $request->validate([
            'user_id' => 'required',
            'rowid' => 'required'  
        ]);

        if(!company::where('user_id',$validated['user_id'])->first())
        {
            return redirect(route('quick'));
        }

        $data = [
            'validated'=>$validated,
            'rowid' => $validated['rowid'],
            'remark' => cart::get($validated['rowid']),
        ];

        return view('quickorder.add_remark',$data);
    }//end method

    public function update_remark(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'rowid' => 'required',  // Ensure rowid exists in the cart
            'remark' => 'required',           // Validate remark
            'cost' => 'required',                    // Validate cost
            'description' => 'nullable',      // Validate description
            'category' => 'required',        // Validate category
            'discount' => 'required',
        ]);

        if(!company::where('user_id',$validated['user_id'])->first())
        {
            return redirect(route('quick'));
        }

        // Get the current cart item
        $cartItem = Cart::get($validated['rowid']);
        
        if (!$cartItem) {
            return redirect(route('quick.cart.view').'?user_id='.$validated['user_id'])->with('error', 'Item not found in cart.');
        }

        // Merge the updated fields into the current options
        $updatedOptions =  [
            'remark' => $validated['remark'],
            'cost' => $validated['cost'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'discount' => $validated['discount'],
        ];

        //Cart::update($validated['rowid'], ['remark' => $validated['remark']]);

        // Update the cart item with the merged options
        Cart::update($validated['rowid'], [
            'options' => $updatedOptions
        ]);

        return redirect(route('quick.cart.view').'?user_id='.$validated['user_id'])->with('success', 'remark add to items');
    }//end method

    public function update_quantity_page(Request $request)
    {
        // check id input exist
        $validated = $request->validate([
            'user_id' => 'required',
            'rowid' => 'required',  // Ensure rowid exists in the cart
        ]);

        if(!company::where('user_id',$validated['user_id'])->first())
        {
            return redirect(route('quick'));
        }

        $data = [
            'validated'=>$validated,
            'rowid' => cart::get($validated['rowid']),
        ];

        return view('quickorder.update_quantity',$data);
    }//end method

    //update quantity items selected in cart
    public function update_quantity(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'rowid' => 'required',  // Ensure rowid exists in the cart
        ]);

        if(!company::where('user_id',$validated['user_id'])->first())
        {
            return redirect(route('quick'));
        }

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
    
                    return redirect(route('quick.cart.view').'?user_id='.$validated['user_id']);
                }

            }
            return redirect(route('quick.cart.view').'?user_id='.$validated['user_id'])->with('error', 'quantity cannot negetif added have a problem!!!');
        }

        return redirect(route('quick.cart.view').'?user_id='.$validated['user_id'])->with('error', 'Item added have a problem.');
    }//emd method

    public function cart_checkout_pay_online(Request $request)
    {
        // get date today for bill 
        $now = Carbon::now();
        $date = $now->format('d-m-Y');
        $time = $now->format('H:i:s');
        
        $bill_id = Carbon::now()->timestamp; // get timestamp for bill id

        $validated = $request->validate([
    
            'name' => 'required',
            'email' => 'required|email',
            'user_id' => 'required',
        ]);

        $toyyibpay = toyyibpay::where('user_id',$validated['user_id'])->first();
        if(!$toyyibpay)
        {
            return redirect(route('quick.list').'?user_id='.$validated['user_id'])->with('error', 'seller pay online is not ready');
        }

        

        $some_data = array(
            'userSecretKey'=> Crypt::decryptString($toyyibpay->toyyip_key), // your secret key here in accout
            'catname' => 'point of sale ',
            'catdescription' => 'payment online ',
            'categoryCode'=> Crypt::decryptString($toyyibpay->toyyip_category),
            'billName'=>'product on the list',
            'billDescription'=>'Online Payment Method System P.O.S',
            'billPriceSetting'=>0,
            'billPayorInfo'=>0,
            'billAmount'=>round(Cart::total() * 20)/ 20 * 100,
            'billReturnUrl'=>route('invoice.payment.status'), //tukar link disini
            'billCallbackUrl'=>route('invoice'),
            'billExternalReferenceNo' => $bill_id , // reference number sendiri bukan toyyyipay punya macam number resit
            'billTo'=>''.$validated['name'],
            'billEmail'=>''.$validated['email'],
            //'billPhone'=>''.$validated['phone_cust'],
            'billSplitPayment'=>0,
            'billSplitPaymentArgs'=>'',
            'billPaymentChannel'=>'0',
            'billContentEmail'=>'Thank you for purchasing our product!',
            //'billExpiryDate'=>'17-12-2020 17:00:00',
            'billChargeToCustomer'=>'',
            'billExpiryDays'=>1
        ); 

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, env('TOYYIB_PAY_URL','https://toyyibpay.com/index.php/api/createBill'));  //PROVIDE API LINK HERE
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);  
        curl_close($curl);
        $obj = json_decode($result);

        if(!$obj)
        {
            return redirect()->back()->with('error', 'sorry toyyibpay key or category account is error');
        }


                // Get today's date in 'Y-m-d' format
                $today = Carbon::today()->toDateString();

                // Find the highest number for today's date, default to 0 if no records
                $lastInvoice = Invoice::whereDate('created_at', $today)
                                        ->orderByDesc('daily_unique_number')
                                        ->first();
        
                // If no record exists today, start from 1, otherwise increment the last number
                $newNumber = $lastInvoice ? $lastInvoice->daily_unique_number + 1 : 1;



        
                // store payment cash sales 
                $invoice = new invoice;
                $invoice->invoice_id = $bill_id;
                $invoice->user_id = $validated['user_id'];
                
                $invoice->subtotal = Cart::subtotal();
                $invoice->tax = round(Cart::tax() * 20)/ 20;
                $invoice->total = round(Cart::total() * 20)/ 20;
                $invoice->status = false;
                $invoice->name = $validated['name'];
                $invoice->daily_unique_number = $newNumber;

                $customer = customer::where('email',$validated['email'])->where('user_id',$validated['user_id'])->first();
                if($customer)
                {
        
                    $invoice->phone_cust = $customer->phone;
                    $invoice->email_cust = $customer->email;
                    $invoice->name_cust = $customer->name;
                }
                $invoice->save();



    
                $company = company::where('user_id',$validated['user_id'])->first();
    
                $datas = [
                    'company' => $company,
                    'billcode'=> $obj[0]->BillCode,
                    'invoice' => invoice::firstWhere('invoice_id', $bill_id),
                    'invoice_detail' => invoice_detail::where('invoice_id', $bill_id)->get(),
                    
                ];
        
                Mail::to($validated['email'])->send(new toyyibpay_link( $datas));

                        // store items list for bill
        foreach(Cart::content() as $row)
        {


            //store data to list item buy
            $invoice_detail = new invoice_detail;
            $invoice_detail->invoice_id = $bill_id;
            $invoice_detail->shortcode = $row->id;
            $invoice_detail->name = $row->name;
            $invoice_detail->quantity = $row->qty;
            $invoice_detail->price = $row->price;
            $invoice_detail->cost = $row->options->cost;
            $invoice_detail->discount = $row->options->discount;
            $invoice_detail->description = $row->options->description;
            $invoice_detail->category = $row->options->category;
            $invoice_detail->remark = $row->options->remark;
            $invoice_detail->user_id = $validated['user_id'];
            $invoice_detail->save();

            if($row->options->category== 'retail')
            {

                    //store data update to database
                    $item = item::where('shortcode',$row->id)->first();
                    $item->quantity = $item->quantity - $row->qty;
                    $item->save();
                

            }

        }//end loop product details
        

        Cart::destroy();// remove all items in cart 


            return redirect(route('quick.list').'?user_id='.$validated['user_id'])->with('success', 'link send to customer!!!');

        


    }//end method

}//end class
