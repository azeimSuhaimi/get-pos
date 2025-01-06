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
    .order-details {
        margin-bottom: 20px;
    }
    .order-details p {
        margin: 5px 0;
    }
    .items-list {
        margin-bottom: 20px;
    }
    .items-list table {
        width: 100%;
        border-collapse: collapse;
    }
    .items-list th, .items-list td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    .total {
        margin-bottom: 20px;
    }
    .footer {
        font-size: 0.8em;
        color: #777;
    }
</style>




<div class="container">
    <div class="header">
        <div style="text-align: center;margin: 0;"> <h1 style="margin: 0;">{{$company->shop_name}}</h1></div>
        <div style="text-align: center;margin: 0;"> <h2 style="margin: 0;">{{$company->company_name}}</h2></div>
        <div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">Company No : {{$company->company_id}}</h4></div>
        <div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">{{$company->address}}, {{$company->city}}</h4></div>
        <div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">{{$company->poscode}}, {{$company->state}}, {{$company->country}}.</h4></div>
        <div style="text-align: center;margin: 0;"> <h4 style="margin: 0;">Phone No : {{$company->phone}}</h4></div>

        <br>

        <h3>Quick Order</h3>

        <h1>Receipt for Order #{{$quickorder->barcode}}</h1>
    </div>
    <div class="order-details">
        
        <p><strong>Date:</strong> #{{$quickorder->created_at}}</p>

    </div>
    <div class="items-list">
        <h3>Items Order:</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quickorder_detail as $row)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row->shortcode}}</td>
                        <td>{{$row->name}}</td>
                        <td>{{$row->price}}</td>
                        <td>{{$row->quantity}}</td>
                        <td>{{$row->quantity * $row->price}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="total">
        <p><strong>Subtotal:</strong> {{$quickorder->subtotal}}</p>
        <p><strong>Tax:</strong> {{$quickorder->tax}}</p>
        <p><strong>Total:</strong> {{$quickorder->total}}</p>

        
        
        

        
    </div>

    <div class="">
        <p>Please show this email to cashier. If you have any questions or concerns regarding your purchase, feel free to reach out to our customer support team.</p>
        <p>Thank you for choosing {{$company->company_name}}!</p>
        <p>Best regards,<br>{{$company->company_name}} {{$company->company_id}}</p>
        <p>Contact Information: {{$company->phone}}</p>
    </div>

</div>