<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\company;
use App\Models\invoice;
use App\Models\suspend;
use App\Models\customer;
use App\Models\toyyibpay;
use App\Mail\toyyibpay_link;
use App\Models\activity_log;

use App\Models\payment_type;
use Illuminate\Http\Request;
use App\Models\invoice_detail;
use App\Models\payment_method;
use Illuminate\Support\Carbon;
use App\Models\purchase_detail;
use App\Models\suspend_details;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Encryption\DecryptException;


class invoiceController extends Controller
{
    // bill payment option page
    public function index()
    {

        // check total amount in cart exist or not
        if(Cart::total() <= 0)
        {
            return redirect()->back()->with('error', 'item cannot empty  to create bill!!!');
        }
        return view('invoice.index');
    }//end method

    // cash method page for tender
    public function cash_method(Request $request)
    {
        //get all list custmer data
        $customer = customer::where('user_id',auth()->user()->id)->get();

        // check total amount in cart exist or not
        if(Cart::total() <= 0)
        {
            return redirect()->back()->with('error', 'item cannot empty  to create bill!!!');
        }
        return view('invoice.cash_method',['customer'=>$customer,'request'=>$request]);
    }//end method

    public function digital_method(Request $request)
    {
        //get all list custmer data
        $customer = customer::where('user_id',auth()->user()->id)->get();
        $payment_type = payment_type::all();

        // check total amount in cart exist or not
        if(Cart::total() <= 0)
        {
            return redirect()->back()->with('error', 'item cannot empty  to create bill!!!');
        }
        return view('invoice.digital_method',['customer'=>$customer,'request'=>$request, 'payment_type' => $payment_type]);
    }//end method

    public function hybrid_method(Request $request)
    {
        //get all list custmer data
        $customer = customer::where('user_id',auth()->user()->id)->get();
        $payment_type = payment_type::all();
        
        // check total amount in cart exist or not
        if(Cart::total() <= 0)
        {
            return redirect()->back()->with('error', 'item cannot empty  to create bill!!!');
        }
        return view('invoice.hybrid_method',['customer'=>$customer,'request'=>$request, 'payment_type' => $payment_type]);
    }//end method

    public function toyyibpay_method(Request $request)
    {
        //get all list custmer data
        $customer = customer::where('user_id',auth()->user()->id)->get();

        // check total amount in cart exist or not
        if(Cart::total() <= 0)
        {
            return redirect()->back()->with('error', 'item cannot empty  to create bill!!!');
        }
        return view('invoice.toyyibpay_method',['customer'=>$customer,'request'=>$request]);
    }//end method

    public function add_member_cash(Request $request)
    {
        //get all list custmer data
        $customer = customer::where('user_id',auth()->user()->id)->get();

        // check total amount in cart exist or not
        if(Cart::total() <= 0)
        {
            return redirect()->back()->with('error', 'item cannot empty  to create bill!!!');
        }
        return view('invoice.add_member',['customer'=>$customer,'request'=>$request]);
    }//end method

    public function add_member_digital(Request $request)
    {
        //get all list custmer data
        $customer = customer::where('user_id',auth()->user()->id)->get();

        // check total amount in cart exist or not
        if(Cart::total() <= 0)
        {
            return redirect()->back()->with('error', 'item cannot empty  to create bill!!!');
        }
        return view('invoice.add_member',['customer'=>$customer,'request'=>$request]);
    }//end method

    public function add_member_hybrid(Request $request)
    {
        //get all list custmer data
        $customer = customer::where('user_id',auth()->user()->id)->get();

        // check total amount in cart exist or not
        if(Cart::total() <= 0)
        {
            return redirect()->back()->with('error', 'item cannot empty  to create bill!!!');
        }
        return view('invoice.add_member',['customer'=>$customer,'request'=>$request]);
    }//end method

    public function add_member_toyyibpay(Request $request)
    {
        //get all list custmer data
        $customer = customer::where('user_id',auth()->user()->id)->get();

        // check total amount in cart exist or not
        if(Cart::total() <= 0)
        {
            return redirect()->back()->with('error', 'item cannot empty  to create bill!!!');
        }
        return view('invoice.add_member',['customer'=>$customer,'request'=>$request]);
    }//end method


    // proses cash method 
    public function pay(Request $request)
    {
        if($request->input('payment_type') == 'CASH')
        {
            // validation for amount page
            $validated = $request->validate([
                'amount' => 'required|numeric|gte:'.round(Cart::total() * 20)/ 20,
                'payment_type' => 'required',
            ]);
        }

        if($request->input('DIGITAL_PAY') == 'DIGITAL_PAY')
        {
            // validation for amount page
            $validated = $request->validate([
                'reference_no' => 'required|string',
                'payment_type' => 'required',
                'DIGITAL_PAY' => 'required',
            ]);
        }

        if($request->input('HYBRID') == 'HYBRID')
        {
            // validation for amount page
            $validated = $request->validate([
                'amount' => 'required|numeric|lt:'.round(Cart::total() * 20)/ 20,
                'reference_no' => 'required|string',
                'payment_type' => 'required',
                'HYBRID' => 'required',
            ]);
        }

        if($request->input('TOYYIBPAY') == 'TOYYIBPAY')
        {
            // validation for amount page
            $validated = $request->validate([
                'name_cust' => 'required',
                'email_cust' => 'required',
                'phone_cust' => 'required',
                'payment_type' => 'required',
                'TOYYIBPAY' => 'required',
            ]);
        }


        // get date today for bill 
        $now = Carbon::now();
        $date = $now->format('d-m-Y');
        $time = $now->format('H:i:s');
        
        $bill_id = Carbon::now()->timestamp; // get timestamp for bill id

        // store payment cash sales 
        $invoice = new invoice;
        $invoice->invoice_id = $bill_id;
        $invoice->user_id = auth()->user()->id;
        
        $invoice->subtotal = Cart::subtotal();
        $invoice->tax = round(Cart::tax() * 20)/ 20;
        $invoice->total = round(Cart::total() * 20)/ 20;

        if($request->input('TOYYIBPAY') == 'TOYYIBPAY')
        {
            $invoice->status = false;
        }
        else
        {
            $invoice->status = true;
        }

        
        if($request->input('id_cust') !== null)
        {
            $customer = customer::find($request->input('id_cust'));
            $customer->point += Cart::subtotal();
            $customer->save();

            $invoice->phone_cust = $request->input('phone_cust');
            $invoice->email_cust = $request->input('email_cust');
            $invoice->name_cust = $request->input('name_cust');
        }
        $invoice->save();

        if($request->input('payment_type') == 'CASH')
        {
            // store payment cash type 
            $payment_method = new payment_method;
            $payment_method->invoice_id = $bill_id;
            $payment_method->payment_type = 'CASH';
            $payment_method->tender = $validated['amount'];
            $payment_method->status = true;
            $payment_method->user_id = auth()->user()->id;
            $payment_method->save();
        }

        if($request->input('DIGITAL_PAY') == 'DIGITAL_PAY')
        {
            // store payment cash type 
            $payment_method = new payment_method;
            $payment_method->invoice_id = $bill_id;
            $payment_method->payment_type = $validated['payment_type'];
            $payment_method->tender = round(Cart::total() * 20)/ 20;
            $payment_method->reference_no = $validated['reference_no'];
            $payment_method->status = true;
            $payment_method->user_id = auth()->user()->id;
            $payment_method->save();
        }

        if($request->input('HYBRID') == 'HYBRID')
        {
            // store payment cash type 
            $payment_method = new payment_method;
            $payment_method->invoice_id = $bill_id;
            $payment_method->payment_type = 'CASH';
            $payment_method->tender = $validated['amount'];
            $payment_method->status = true;
            $payment_method->user_id = auth()->user()->id;
            $payment_method->save();

            
            $payment_method = new payment_method;
            $payment_method->invoice_id = $bill_id;
            $payment_method->payment_type = $validated['payment_type'];
            $payment_method->tender = round(Cart::total() * 20)/ 20 - $validated['amount'];
            $payment_method->reference_no = $validated['reference_no'];
            $payment_method->status = true;
            $payment_method->user_id = auth()->user()->id;
            $payment_method->save();

        }

        if($request->input('TOYYIBPAY') == 'TOYYIBPAY')
        {

            $toyyibpay = toyyibpay::where('user_id',auth()->user()->id)->first();

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
                'billTo'=>''.$validated['name_cust'],
                'billEmail'=>''.$validated['email_cust'],
                'billPhone'=>''.$validated['phone_cust'],
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
            curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');  //PROVIDE API LINK HERE
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

            $result = curl_exec($curl);
            $info = curl_getinfo($curl);  
            curl_close($curl);
            $obj = json_decode($result);



            $company = company::where('user_id',auth()->user()->id)->first();

            $datas = [
                'company' => $company,
                'billcode'=> $obj[0]->BillCode,
                'invoice' => invoice::firstWhere('invoice_id', $bill_id),
                'invoice_detail' => invoice_detail::where('invoice_id', $bill_id)->get(),
                
            ];
    
            Mail::to($validated['email_cust'])->send(new toyyibpay_link( $datas));
        }


        // store items list for bill
        foreach(Cart::content() as $row)
        {
            if($request->input('id_cust') !== null)
            {
                $purchase_detail = new purchase_detail;
                $purchase_detail->id_cust = $request->input('id_cust');
                $purchase_detail->invoice_id = $bill_id;
                
                $purchase_detail->shortcode = $row->id;
                $purchase_detail->name = $row->name;
                $purchase_detail->quantity = $row->qty;
                $purchase_detail->price = $row->price;
                $purchase_detail->cost = $row->options->cost;
                $purchase_detail->description = $row->options->description;
                $purchase_detail->user_id = auth()->user()->id;
                $purchase_detail->save();

            }

            //store data to list item buy
            $invoice_detail = new invoice_detail;
            $invoice_detail->invoice_id = $bill_id;
            $invoice_detail->shortcode = $row->id;
            $invoice_detail->name = $row->name;
            $invoice_detail->quantity = $row->qty;
            $invoice_detail->price = $row->price;
            $invoice_detail->cost = $row->options->cost;
            $invoice_detail->description = $row->options->description;
            $invoice_detail->category = $row->options->category;
            $invoice_detail->remark = $row->options->remark;
            $invoice_detail->user_id = auth()->user()->id;
            $invoice_detail->save();

            if($row->options->category== 'retail')
            {
                if($request->input('TOYYIBPAY') !== 'TOYYIBPAY')
                {
                    //store data update to database
                    $item = item::where('shortcode',$row->id)->first();
                    $item->quantity = $item->quantity - $row->qty;
                    $item->save();
                }

            }

        }//end loop product details

        Cart::destroy();// remove all items in cart 

        if($request->input('TOYYIBPAY') == 'TOYYIBPAY')
        {
            return redirect(route('dashboard'))->with('success', 'link send to customer!!!');
        }
        else
        {
            return redirect(route('invoice.receipt').'?invoice_id='.$bill_id);
        }

        

    }//end method


    public function invoice_receipt(Request $request)
    {
        if($request->has('invoice_id'))
        {
            $invoice = invoice::where('invoice_id',$request->input('invoice_id'))->first();
            $invoice_detail = invoice_detail::where('invoice_id',$request->input('invoice_id'))->get();
            $payment_method = payment_method::where('invoice_id',$request->input('invoice_id'))->get();
            $payment_type = payment_type::all();

            $data = [
                'payment_type' => $payment_type,
                'invoice' => $invoice,
                'invoice_detail' => $invoice_detail,
                'payment_method' => $payment_method,
                'invoice_id'=>$request->input('invoice_id'),
                
            ];
            return view('receipt.receipt',$data);
        }
        else
        {
            return redirect()->back()->with('error', 'invoice id for  bill not exist!!!');
        }
    }//end method

    public function list_online_manual(Request $request)
    {
        $invoice = invoice::where('user_id',auth()->user()->id)->where('status',false)->orderBy('created_at','desc')->get();

        return view('invoice.list_online_manual',['invoice' => $invoice]);
    }//end method

    public function invoice_online_manual(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required',
        ]);

        
        $invoice = invoice::where('invoice_id',$validated['invoice_id'])->first();

        return view('invoice.invoice_online_manual',['invoice'=>$invoice,'request'=>$request]);

        
    }//end method

    public function invoice_online_manual_process(Request $request)
    {
            $user_id =auth()->user()->id;

            // validation for amount page
            $validated = $request->validate([
                'reference_no' =>  ['required',Rule::unique('payment_methods')->where(function($query) use ($user_id)
                {
                    return $query->where('user_id', $user_id); // Adjust as necessary
                })],
                'invoice_id' => 'required',
            ]);

            // store payment cash type 
            $payment_method = new payment_method;
            $payment_method->invoice_id = $validated['invoice_id'];
            $payment_method->payment_type = 'TOYYIBPAY';
            $payment_method->tender = invoice::where('invoice_id', $validated['invoice_id'])->first()->total;
            $payment_method->reference_no = $validated['reference_no'];
            $payment_method->status = true;
            $payment_method->user_id = auth()->user()->id;
            $payment_method->save();

            invoice::where('invoice_id', $validated['invoice_id'])->update(['status' => true]);
            
            activity_log::addActivity('manual online ',' key in invoice online by manual '.$validated['invoice_id']);

            return redirect(route('invoice.receipt').'?invoice_id='.$validated['invoice_id']);
    }//enc method


}//end class
