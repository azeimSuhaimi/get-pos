<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }
    .header {
        text-align: center;
        margin-bottom: 20px;
    }
    .payment-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
    }
    .invoice-details {
        margin-bottom: 20px;
    }
    .invoice-details p {
        margin: 5px 0;
    }
    .footer {
        font-size: 0.8em;
        color: #777;
    }
</style>
<div class="container">
    <div class="header">
        <div style="text-align: center;margin: 0;"> <h2 style="margin: 0;">{{$company->company_name}}</h2></div>
        <div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">Company No : {{$company->company_id}}</h4></div>
        <div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">{{$company->address}}, {{$company->city}}</h4></div>
        <div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">{{$company->poscode}}, {{$company->state}}, {{$company->country}}.</h4></div>
        <div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">Phone No : {{$company->phone}}</h4></div>

        <br>
        
        <h2>Payment Request</h2>
    </div>
    <p>Subject: Payment Request for {{$invoice['reference_no']}}</p>
    <p>Dear {{$invoice['name_cust']}},</p>
    <p>We kindly request the payment of <strong>RM {{$invoice['total']}}</strong> for Invoice #{{$invoice['invoice_id']}}.</p>
    <p>To facilitate this process, please find the payment link provided below:</p>
    <a href="http://dev.toyyibpay.com/{{$billcode}}">pay now</a>
    <div class="invoice-details">
        <p><strong>Invoice Details:</strong></p>
        <p><strong>Invoice Number:</strong> #{{$invoice['invoice_id']}}</p>
        <p><strong>Amount Due:</strong> RM {{$invoice['total']}}</p>
        <p><strong>Date:</strong> {{$invoice['created_at']}}</p>
    </div>

    <p>Should you have any questions or need further clarification regarding the payment, please don't hesitate to contact us.</p>
    <p>Thank you for your prompt attention to this matter.</p>
        
    <?php 
        $company = DB::table('companies')->where('user_id', auth()->user()->id)->first();
    
    ?>
    <div class="">
        <p>Best regards,<br>{{$company->company_name}} {{$company->company_id}}</p>
        <p>Contact Information: {{$company->phone}}</p>
    </div>

</div>



