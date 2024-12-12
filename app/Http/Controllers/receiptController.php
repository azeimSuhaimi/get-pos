<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoice;
use App\Models\item;
use App\Models\suspend;
use App\Models\suspend_details;
use App\Models\invoice_detail;
use App\Models\payment_method;
use App\Models\customer;
use App\Models\purchase_detail;
use App\Models\payment_type;

class receiptController extends Controller
{
    public function index()
    {
        $invoice = invoice::where('user_email',auth()->user()->email)->where('status',true)->whereDate('created_at', today())->orderBy('created_at','desc')->get();

        return view('receipt.index',['invoice' => $invoice]);
    }// end method

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

}//end class
