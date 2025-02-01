<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\invoice_detail;
use App\Models\payment_method;
use App\Models\payment_type;
use App\Models\notification;
use Illuminate\Http\Request;

class notificationController extends Controller
{
    public function index(Request $request)
    {
        $notification = notification::where('status',false)->get();// id items input

        return view('notification.index',['notification'=>$notification]);
    }//end method

    public function show(Request $request)
    {
            // validation for amount page
            $validated = $request->validate([
                'id' => 'required',
                
            ]);
            $notification = notification::where('invoice_id',$validated['id'])->first();
            $notification->status_read = true;
            $notification->save();

            $invoice = invoice::find($validated['id']);
            $invoice_detail = invoice_detail::where('invoice_id',$invoice->invoice_id)->get();
            $payment_method = payment_method::where('invoice_id',$request->input('invoice_id'))->get();
            $payment_type = payment_type::all();

            $data = [
                'payment_type' => $payment_type,
                'invoice' => $invoice,
                'invoice_detail' => $invoice_detail,
                'payment_method' => $payment_method,
                'invoice_id'=>$request->input('invoice_id'),
                
            ];

        return view('notification.view',$data);
    }//end method

    public function edit(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            
        ]);
        $notification = notification::where('invoice_id',$validated['id'])->first();
        $notification->status = true;
        $notification->save();
        return redirect(route('notification'))->with('success', 'success ');
    }//end method

}//end class
