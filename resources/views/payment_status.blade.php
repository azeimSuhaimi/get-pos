
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Payment Status</title>
          <!-- Vendor CSS Files -->
        <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
        <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    </head>
    <body>
        <div id="layoutError">
            <div id="layoutError_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="text-center ">

                                    @if ($status_id == 1)
                                        
                                        <i class="bi alarm-fille"></i>
                                        <h2 class="card-title text-center">Your Payment Success.</h2>
                                        <p class="text-center small">Congratulations! your purchase is now complate</p>
                                        <p class="text-center small">Click And Take Screenshot this page for proof and record.</p>
                                    
                                        
                                    @endif

                                    @if ($status_id == 2)
                                        <i class="bi alarm-fille"></i>
                                        <h2 class="card-title text-center">Your Payment Fail.</h2>
                                        <p class="text-center small">Click To Try Again Payment.</p>
                                        <a target="_blank" href="http://dev.toyyibpay.com/{{$billcode}}">click here for details</a>
                                    @endif

                                    @if ($status_id == 3)
                                        <i class="bi alarm-fille"></i>
                                        <h2 class="card-title text-center">Unknown Status Payment.</h2>
                                        <p class="text-center small">Click To Try Again Payment</p>

                                        <a target="_blank" href="http://dev.toyyibpay.com/{{$billcode}}">click here for details</a>
                                    @endif

<hr>

                                    <p>Amount</p>
                                    <h3 class="mt-0">RM {{$obj->billpaymentAmount}}</h3>



                                    <!-- -->
                                    @if ($status_id == 1)
                                        <div class="card text-bg-light">
                                            <div class="card-body">
                                        
                                                <div class="row mb-3 mt-5">
                                                    <label for="inputText" class="col-sm-3 col-form-label">Order number</label>
                                                    <div class="col-sm-9">
                                                        #{{$invoice_id}}
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-3 col-form-label">transaction ID</label>
                                                    <div class="col-sm-9">
                                                        #{{$obj->billpaymentInvoiceNo}}
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-3 col-form-label">paid on</label>
                                                    <div class="col-sm-9">
                                                        {{$obj->billPaymentDate}}
                                                    </div>
                                                </div>

                                                <a target="_blank" href="http://dev.toyyibpay.com/{{$billcode}}">click here for details</a>

                                            </div>
                                        </div>
                                        
                                    @endif
                                    

                                    
                                    @if ($status_id == 3)
                                        <p class="lead">Unknown Status Payment </p>
                                        <p>Your Payment Status Is Unknown.</p>
                                        <p>Click To Try Again Payment.</p>
                                        <a target="_blank" href="http://dev.toyyibpay.com/{{$billcode}}">click here for details</a>
                                    @endif
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <!-- 
            <div id="layoutError_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            -->
        </div>
          <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/quill/quill.js')}}"></script>
  <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>
    </body>
</html>




<h1></h1>

