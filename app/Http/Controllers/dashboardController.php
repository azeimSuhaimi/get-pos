<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\invoice;
use App\Models\invoice_detail;
use App\Models\payment_method;
use App\Models\customer;
use App\Models\purchase_detail;
use App\Models\activity_log;
use App\Models\company;
use App\Models\payment_type;
use App\Models\item;

use App\Mail\send_receipt;

class dashboardController extends Controller
{
    public function index()
    {

        $invoice = invoice::where('status',false)->whereDate('created_at', Carbon::yesterday())->get();

        foreach($invoice as $inv)
        {
            $deleted = invoice::where('invoice_id', $inv->invoice_id)->delete();
            invoice_detail::where('invoice_id', $inv->invoice_id)->delete();
        }

        // Get today's date range
        $todayStart = Carbon::today(); // 00:00:00
        $todayEnd = Carbon::today()->endOfDay(); // 23:59:59

        // Get yesterday's date range
        $yesterdayStart = Carbon::yesterday(); // 00:00:00
        $yesterdayEnd = Carbon::yesterday()->endOfDay(); // 23:59:59

        // Get this month's date range
        $thisMonthStart = Carbon::now()->startOfMonth(); // First day of this month at 00:00:00
        $thisMonthEnd = Carbon::now()->endOfMonth(); // Last day of this month at 23:59:59

        // Get this year's date range
        $thisYearStart = Carbon::now()->startOfYear(); // First day of this year at 00:00:00
        $thisYearEnd = Carbon::now()->endOfYear(); // Last day of this year at 23:59:59

       
        $totalsaleToday = invoice::where('user_id',auth()->user()->id)->whereBetween('created_at', [$todayStart,$todayEnd])->where('status', true)->sum('subtotal');
        $totalsaleYesterday = invoice::where('user_id',auth()->user()->id)->whereBetween('created_at',[$yesterdayStart,$yesterdayEnd])->where('status', true)->sum('subtotal');
        $totalsaleMonth = invoice::where('user_id',auth()->user()->id)->whereBetween('created_at',[$thisMonthStart,$thisMonthEnd])->where('status', true)->sum('subtotal');
        $totalsaleYear = invoice::where('user_id',auth()->user()->id)->whereBetween('created_at',[$thisYearStart,$thisYearEnd])->where('status', true)->sum('subtotal');

        $customerCountToday = invoice::where('user_id',auth()->user()->id)->whereBetween('created_at', [$todayStart,$todayEnd])->where('status', true)->count('invoice_id');
        $customerCountYesterday = invoice::where('user_id',auth()->user()->id)->whereBetween('created_at',[$yesterdayStart,$yesterdayEnd])->where('status', true)->count('invoice_id');
        $customerCountMonth = invoice::where('user_id',auth()->user()->id)->whereBetween('created_at',[$thisMonthStart,$thisMonthEnd])->where('status', true)->count('invoice_id');
        $customerCountYear = invoice::where('user_id',auth()->user()->id)->whereBetween('created_at',[$thisYearStart,$thisYearEnd])->where('status', true)->count('invoice_id');

        // Fetch activities sorted by most recent
        $activities = activity_log::where('user_id',auth()->user()->id)->orderBy('created_at', 'desc')->limit(6)->get();

        $itemsWithTotalQuantityToday = invoice_detail::whereBetween('created_at', [$todayStart,$todayEnd])->where('user_id', auth()->user()->id)->select('shortcode',
        \DB::raw('COUNT(quantity) as total_quantity'), 
        \DB::raw('MAX(name) as name'), // Pick the first 'name' (or MAX, MIN, etc.)
        \DB::raw('MAX(price) as price')) 
        ->groupBy('shortcode') 
        ->get();

        $invoice = invoice::whereBetween('created_at', [$todayStart,$todayEnd])->where('user_id',auth()->user()->id)->orderBy('created_at', 'desc')->get();

        $items_low_stock = item::where('user_id',auth()->user()->id)->where('quantity','<',10)->where('category','retail')->orderBy('quantity','desc')->get();

        //echo $totalsaleToday;
        $data = [
            'items_low_stock' => $items_low_stock,
            'totalsaleToday' => $totalsaleToday,
            'totalsaleYesterday' => $totalsaleYesterday,
            'totalsaleMonth' => $totalsaleMonth,
            'totalsaleYear' => $totalsaleYear,
            'customerCountToday' => $customerCountToday,
            'customerCountYesterday' => $customerCountYesterday,
            'customerCountMonth' => $customerCountMonth,
            'customerCountYear' => $customerCountYear,
            'activities' => $activities,
            'itemsWithTotalQuantityToday' => $itemsWithTotalQuantityToday,
            'invoice' => $invoice,
        ];


        return view('dashboard.index',$data);
    }// end method


    public function send_receipt(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required',
            'email' => 'required|email',
        ]);

        $company = company::where('user_id',auth()->user()->id)->first();
        $payment_type = payment_type::all();

        $datas = [
            'payment_type' => $payment_type,
            'company' => $company,
            'invoice' => invoice::firstWhere('invoice_id', $validated['invoice_id']),
            'invoice_detail' => invoice_detail::where('invoice_id', $validated['invoice_id'])->get(),
            'payment_method' => payment_method::where('invoice_id', $validated['invoice_id'])->get()
        ];

        Mail::to($validated['email'])->send(new send_receipt( $datas));
        return redirect(route('dashboard'))->with('success','send receipt to to email '.$validated['email']);
    }//end method


    public function payment_status(Request $request)
    {

        $validated = $request->validate([
            'order_id' => 'required',
            'billcode' => 'required',
            'status_id' => 'required',
            'transaction_id' => 'required'
            ]);

            $some_data = array(
                'billCode' => $validated['billcode'],
                'billpaymentStatus' => '1'
              );  
            
              $curl = curl_init();
            
              curl_setopt($curl, CURLOPT_POST, 1);
              curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/getBillTransactions');  
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
            
              $result = curl_exec($curl);
              $info = curl_getinfo($curl);  
              curl_close($curl);
              $obj = json_decode($result);
              //echo $result;

              //dd($obj);
              $invoice = invoice::firstWhere('invoice_id', $validated['order_id']);

              $company = company::where('user_id',$invoice->user_id)->first();
              $payment_type = payment_type::all();
              
        $datas = [
            'payment_type' => $payment_type,
            'company' => $company,
            'status_id' => $validated['status_id'],
            'billcode' => $validated['billcode'],
            'invoice_id' => $validated['order_id'],
            'invoice' => $invoice,
            'invoice_detail' => invoice_detail::where('invoice_id', $validated['order_id'])->get(),
            'payment_method' => payment_method::where('invoice_id', $validated['order_id'])->get(),
            'obj' => $obj[0]
        ];

            $invoice = invoice::firstWhere('invoice_id', $validated['order_id']);

            if($invoice->status == false && $validated['status_id'] == 1)
            {
                
                $payment_method = new payment_method;
                $payment_method->invoice_id = $validated['order_id'];
                $payment_method->payment_type = 'TOYYIBPAY';
                $payment_method->tender = invoice::where('invoice_id', $validated['order_id'])->first()->total;
                $payment_method->reference_no = $validated['transaction_id'];
                $payment_method->status = true;
                $payment_method->user_id = auth()->user()->id;
                $payment_method->save();

                invoice::where('invoice_id', $validated['order_id'])->update(['status' => true]);
                //payment_method::where('invoice_id', $validated['order_id'])->update(['status' => true]);

                Mail::to($invoice->email_cust)->send(new send_receipt( $datas));
            }

        return view('payment_status',$datas);
    }// end method

}//end class
