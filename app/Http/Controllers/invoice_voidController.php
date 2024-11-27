<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\invoice;
use App\Models\invoice_detail;
use App\Models\payment_method;

use App\Models\invoice_void;
use App\Models\invoice_detail_void;
use App\Models\payment_method_void;

use App\Models\activity_log;

class invoice_voidController extends Controller
{
    public function index()
    {
        $invoice = invoice::where('user_email',auth()->user()->email)->where('status',true)->whereDate('created_at', today())->orderBy('created_at','desc')->get();

        return view('invoice_void.index',['invoice' => $invoice]);
    }// end method

    public function view(Request $request)
    {
        $validated = $request->validate([
                
            'invoice_id' => 'required',
        ]);

        if($request->has('invoice_id'))
        {
            $invoice = invoice::where('invoice_id',$validated['invoice_id'])->first();
            $invoice_detail = invoice_detail::where('invoice_id',$validated['invoice_id'])->get();
            $payment_method = payment_method::where('invoice_id',$validated['invoice_id'])->get();

            
            $data = [
                'invoice' => $invoice,
                'invoice_detail' => $invoice_detail,
                'payment_method' => $payment_method,
                'invoice_id'=>$validated['invoice_id'],
                
            ];
            return view('invoice_void.view',$data);
        }
        else
        {
            return redirect()->back()->with('error', 'invoice id for  bill not exist!!!');
        }
    }// end method

    public function invoice_void(Request $request)
    {


        $validated = $request->validate([
                
            'invoice_id' => 'required',
        ]);

        $invoice = invoice::where('invoice_id',$validated['invoice_id'])->first();
        $invoice_detail = invoice_detail::where('invoice_id',$validated['invoice_id'])->get();
        $payment_method = payment_method::where('invoice_id',$validated['invoice_id'])->get();
        $id = $invoice->invoice_id;

        // store payment cash sales 
        $invoice_void = new invoice_void;
        $invoice_void->invoice_id = $invoice->invoice_id;
        $invoice_void->user_email = $invoice->user_email;
        $invoice_void->subtotal = $invoice->subtotal;
        $invoice_void->tax = $invoice->tax;
        $invoice_void->total = $invoice->total;
        $invoice_void->phone_cust = $invoice->phone_cust;
        $invoice_void->email_cust = $invoice->email_cust;
        $invoice_void->name_cust = $invoice->name_cust;
        $invoice_void->save();

        foreach($payment_method as $pm)
        {
            $payment_method_void = new payment_method_void;
            $payment_method_void->invoice_id = $pm->invoice_id;
            $payment_method_void->payment_type = $pm->payment_type;
            $payment_method_void->tender = $pm->tender;
            $payment_method_void->user_email = $pm->user_email;
            $payment_method_void->save();
        }


        // store items list for bill
        foreach($invoice_detail as $row)
        {
            //store data to list item buy
            $invoice_detail_void = new invoice_detail_void;
            $invoice_detail_void->invoice_id = $row->invoice_id;
            $invoice_detail_void->shortcode = $row->shortcode;
            $invoice_detail_void->name = $row->name;
            $invoice_detail_void->quantity = $row->quantity;
            $invoice_detail_void->price = $row->price;
            $invoice_detail_void->cost = $row->cost;
            $invoice_detail_void->description = $row->description;
            $invoice_detail_void->category = $row->category;
            $invoice_detail_void->remark = $row->remark;
            $invoice_detail_void->user_email = $row->user_email;
            $invoice_detail_void->save();


        }//end loop product details

        activity_log::addActivity('Void Invoice ',' void invoice '.$validated['invoice_id']);

        $invoice = invoice::where('invoice_id',$validated['invoice_id'])->delete();
        $invoice_detail = invoice_detail::where('invoice_id',$validated['invoice_id'])->delete();
        $payment_method = payment_method::where('invoice_id',$validated['invoice_id'])->delete();


        return redirect(route('invoice_void'))->with('success', 'invoice id '.$id.' is void now!!!');;
    }//end method

}//end class
