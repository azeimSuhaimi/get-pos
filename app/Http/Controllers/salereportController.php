<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\invoice;
use App\Models\invoice_detail;
use App\Models\payment_method;
use App\Models\customer;
use App\Models\purchase_detail;
use App\Models\activity_log;
            // reference the Dompdf namespace
            use Dompdf\Dompdf;

class salereportController extends Controller
{
    public function daily_sale_report(Request $request)
    {
        $data = [
            'request' => $request,
        ];

        if($request->input('date') != null)
        {
            $validated = $request->validate([
                'date' => 'required|date',
            ]);

            // Create Carbon instances for the start and end of the day
            $Start = Carbon::createFromFormat('Y-m-d', $validated['date'])->startOfDay();  // First moment of the day (00:00:00)
            $End = Carbon::createFromFormat('Y-m-d', $validated['date'])->endOfDay();

            $totalsale = invoice::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->sum('subtotal');
            $totaltransaction = invoice::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->count('invoice_id');
            $totalgrosssale = invoice::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->sum('total');
            $totaltax = invoice::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->sum('tax');

            $totalpaymenttypecash = payment_method::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->where('payment_type', 'CASH')->get();
            $payment_method = payment_method::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->select('payment_type',
            \DB::raw('sum(tender) as total'),
            \DB::raw('MAX(invoice_id) as invoice'),) 
            ->groupBy('payment_type') 
            ->get();

            $data = [
                'request' => $request,
                'date' => $validated['date'],
                'totalsale' => $totalsale,
                'totaltransaction' => $totaltransaction,
                'totalgrosssale' => $totalgrosssale,
                'totaltax' => $totaltax,
                'payment_method' => $payment_method,
                'totalpaymenttypecash' => $totalpaymenttypecash,

            ];

            
        }//end check date

        return view('salereport.daily_sale_report',$data);
    }// end method

    public function daily_sale_report_pdf(Request $request)
    {
        if($request->input('date') != null)
        {
            $validated = $request->validate([
                'date' => 'required|date',
            ]);

            // Create Carbon instances for the start and end of the day
            $Start = Carbon::createFromFormat('Y-m-d', $validated['date'])->startOfDay();  // First moment of the day (00:00:00)
            $End = Carbon::createFromFormat('Y-m-d', $validated['date'])->endOfDay();

            $totalsale = invoice::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->sum('subtotal');
            $totaltransaction = invoice::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->count('invoice_id');
            $totalgrosssale = invoice::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->sum('total');
            $totaltax = invoice::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->sum('tax');

            $totalpaymenttypecash = payment_method::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->where('payment_type', 'CASH')->get();
            $payment_method = payment_method::where('user_email',auth()->user()->email)->whereBetween('created_at', [$Start,$End])->where('status', true)->select('payment_type',
            \DB::raw('sum(tender) as total'),
            \DB::raw('MAX(invoice_id) as invoice'),) 
            ->groupBy('payment_type') 
            ->get();

            $data = [
                'request' => $request,
                'date' => $validated['date'],
                'totalsale' => $totalsale,
                'totaltransaction' => $totaltransaction,
                'totalgrosssale' => $totalgrosssale,
                'totaltax' => $totaltax,
                'payment_method' => $payment_method,
                'totalpaymenttypecash' => $totalpaymenttypecash,

            ];


            // instantiate and use the dompdf class
            $dompdf = new Dompdf();
            $dompdf->loadHtml(view('salereport.daily_sale_report_pdf',$data));

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream();
            
        }//end check date

    }//end method

}//end class
