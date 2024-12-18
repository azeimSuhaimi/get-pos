@extends('layouts.main_layout')
 
@section('title', 'dashboard page')
 
@section('content')

@include('partials.popup')

<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-12">
            <div class="card text-bg-light  info-card sales-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#" id="filter-today">Today</a></li>
                  <li><a class="dropdown-item" href="#" id="filter-yesterday">Yesterday</a></li> <!-- Add Yesterday option -->
                  <li><a class="dropdown-item" href="#" id="filter-month">This Month</a></li>
                  <li><a class="dropdown-item" href="#" id="filter-year">This Year</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title" id="sales-title">Sales <span>| Today</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6 id="sales-amount">RM {{$totalsaleToday}}</h6>
                    <!--
                    <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>
                    -->
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->


          <!-- Customers Card -->
          <div class="col-xxl-4 col-xl-12">

            <div class="card text-bg-light info-card customers-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#" id="filter-today-customer">Today</a></li>
                  <li><a class="dropdown-item" href="#" id="filter-yesterday-customer">Yesterday</a></li> <!-- Add Yesterday option -->
                  <li><a class="dropdown-item" href="#" id="filter-month-customer">This Month</a></li>
                  <li><a class="dropdown-item" href="#" id="filter-year-customer">This Year</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title" id="customer-title">Customers <span>| Today</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6 id="customer-count">{{$customerCountToday}}</h6>
                    <!--
                    <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>
                    -->
                  </div>
                </div>

              </div>
            </div>

          </div><!-- End Customers Card -->



          <!-- Recent Sales -->
          <div class="col-12">
            <div class="card text-bg-light recent-sales overflow-auto">

              <!-- 
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div> -->

              <div class="card-body">
                <h5 class="card-title">Recent Sales <span>| Today</span></h5>

                <table class="table table-hover table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Invoice ID</th>
                      <th scope="col">Date</th>
                      <th scope="col">Total</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($invoice as $row )
                      
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <th scope="row"><a href="{{route('receipt.view').'?invoice_id='.$row->invoice_id}}">#{{$row->invoice_id}}</a></th>
                        <td>{{$row->created_at}}</td>
                        <td>{{$row->total}}</td>
                        <td><span class="badge  {{$row->status == true ? 'bg-success':'bg-danger'}}">{{$row->status == true ? 'Paid':'Unpaid'}}</span></td>
                      </tr>
                    @endforeach


                    
                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Recent Sales -->

          <!-- Top Selling -->
          <div class="col-12">
            <div class="card text-bg-light top-selling overflow-auto">

              <!--
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div> -->

              <div class="card-body pb-0">
                <h5 class="card-title">Top Selling <span>| Today</span></h5>

                <table class="table table-borderless table-hover datatable">
                  <thead>
                    <tr>
                      <th scope="col">Preview</th>
                      <th scope="col">Product</th>
                      <th scope="col">Price</th>
                      <th scope="col">Sold</th>
                      <th scope="col">Revenue</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($itemsWithTotalQuantityToday as $row)
                      <?php 
                        $item = DB::table('items')
                        ->where('user_email',auth()->user()->email)
                        ->where('shortcode', $row->shortcode)
                        ->first();
                      
                      ?>
                      <tr>
                        <th scope="row"><a href="#"><img src="items/{{$item->picture}}" alt=""></a></th>
                        <td><a href="{{route('item.view')}}?id={{$item->id}}" target="_blank" class="text-primary fw-bold">{{$row->name}}</a></td>
                        <td>RM {{$row->price}}</td>
                        <td class="fw-bold">{{$row->total_quantity}}</td>
                        <td>RM {{$row->price *$row->total_quantity}}</td>
                      </tr>
                    @endforeach

                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Top Selling -->

        </div>
      </div><!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="col-lg-4">

        <!-- Recent Activity -->
        <div class="card text-bg-light">
          <div class="card-body">
            <h5 class="card-title">Recent Activity </h5>
            <div class="activity">

              @foreach ($activities as $activitie)
                
                <div class="activity-item d-flex">
                  <div class="activite-label">{{ \Carbon\Carbon::parse($activitie->created_at)->diffForHumans() }}</div>
                  <i class='bi bi-circle-fill activity-badge text-{{ $loop->index % 5 == 0 ? 'success' : ($loop->index % 5 == 1 ? 'danger' : ($loop->index % 5 == 2 ? 'primary' : ($loop->index % 5 == 3 ? 'info' : 'warning'))) }} align-self-start'></i>
                  <div class="activity-content">
                    {{$activitie->details}}
                  </div>
                </div><!-- End activity item-->
              @endforeach

            </div>

          </div>
        </div><!-- End Recent Activity -->

        <!-- Recent stock low -->
        <div class="card text-bg-light">
          <div class="card-body">
            <h5 class="card-title">Stock Lower </h5>
            <div class="activity">

              @foreach ($items_low_stock as $row)
                
                <div class="activity-item d-flex">
                  <div class="activite-label">{{ $row->quantity }}</div>
                  <i class='bi bi-circle-fill activity-badge text-{{ $loop->index % 5 == 0 ? 'success' : ($loop->index % 5 == 1 ? 'danger' : ($loop->index % 5 == 2 ? 'primary' : ($loop->index % 5 == 3 ? 'info' : 'warning'))) }} align-self-start'></i>
                  <div class="activity-content">
                    <a href="{{route('item.view')}}?id={{$row->id}}">{{$row->name}}</a>
                  </div>
                </div><!-- End activity item-->
              @endforeach

            </div>

          </div>
        </div><!-- End stock low -->

        <!-- Budget Report -->
        <!--<div class="card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filter</h6>
              </li>

              <li><a class="dropdown-item" href="#">Today</a></li>
              <li><a class="dropdown-item" href="#">This Month</a></li>
              <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
          </div>

          <div class="card-body pb-0">
            <h5 class="card-title">Budget Report <span>| This Month</span></h5>

            <div id="budgetChart" style="min-height: 400px;" class="echart"></div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                var budgetChart = echarts.init(document.querySelector("#budgetChart")).setOption({
                  legend: {
                    data: ['Allocated Budget', 'Actual Spending']
                  },
                  radar: {
                    // shape: 'circle',
                    indicator: [{
                        name: 'Sales',
                        max: 6500
                      },
                      {
                        name: 'Administration',
                        max: 16000
                      },
                      {
                        name: 'Information Technology',
                        max: 30000
                      },
                      {
                        name: 'Customer Support',
                        max: 38000
                      },
                      {
                        name: 'Development',
                        max: 52000
                      },
                      {
                        name: 'Marketing',
                        max: 25000
                      }
                    ]
                  },
                  series: [{
                    name: 'Budget vs spending',
                    type: 'radar',
                    data: [{
                        value: [4200, 3000, 20000, 35000, 50000, 18000],
                        name: 'Allocated Budget'
                      },
                      {
                        value: [5000, 14000, 28000, 26000, 42000, 21000],
                        name: 'Actual Spending'
                      }
                    ]
                  }]
                });
              });
            </script>

          </div>
        </div> End Budget Report -->

        <!-- Website Traffic -->
        <!--<div class="card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filter</h6>
              </li>

              <li><a class="dropdown-item" href="#">Today</a></li>
              <li><a class="dropdown-item" href="#">This Month</a></li>
              <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
          </div>

          <div class="card-body pb-0">
            <h5 class="card-title">Website Traffic <span>| Today</span></h5>

            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

            <script>
              document.addEventListener("DOMContentLoaded", () => {
                echarts.init(document.querySelector("#trafficChart")).setOption({
                  tooltip: {
                    trigger: 'item'
                  },
                  legend: {
                    top: '5%',
                    left: 'center'
                  },
                  series: [{
                    name: 'Access From',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    label: {
                      show: false,
                      position: 'center'
                    },
                    emphasis: {
                      label: {
                        show: true,
                        fontSize: '18',
                        fontWeight: 'bold'
                      }
                    },
                    labelLine: {
                      show: false
                    },
                    data: [{
                        value: 1048,
                        name: 'Search Engine'
                      },
                      {
                        value: 735,
                        name: 'Direct'
                      },
                      {
                        value: 580,
                        name: 'Email'
                      },
                      {
                        value: 484,
                        name: 'Union Ads'
                      },
                      {
                        value: 300,
                        name: 'Video Ads'
                      }
                    ]
                  }]
                });
              });
            </script>

          </div>
        </div> End Website Traffic -->

        <!-- News & Updates Traffic -->
        <!--<div class="card">
          <div class="filter">
            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <li class="dropdown-header text-start">
                <h6>Filter</h6>
              </li>

              <li><a class="dropdown-item" href="#">Today</a></li>
              <li><a class="dropdown-item" href="#">This Month</a></li>
              <li><a class="dropdown-item" href="#">This Year</a></li>
            </ul>
          </div>

          <div class="card-body pb-0">
            <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>

            <div class="news">
              <div class="post-item clearfix">
                <img src="assets/img/news-1.jpg" alt="">
                <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
              </div>

              <div class="post-item clearfix">
                <img src="assets/img/news-2.jpg" alt="">
                <h4><a href="#">Quidem autem et impedit</a></h4>
                <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
              </div>

              <div class="post-item clearfix">
                <img src="assets/img/news-3.jpg" alt="">
                <h4><a href="#">Id quia et et ut maxime similique occaecati ut</a></h4>
                <p>Fugiat voluptas vero eaque accusantium eos. Consequuntur sed ipsam et totam...</p>
              </div>

              <div class="post-item clearfix">
                <img src="assets/img/news-4.jpg" alt="">
                <h4><a href="#">Laborum corporis quo dara net para</a></h4>
                <p>Qui enim quia optio. Eligendi aut asperiores enim repellendusvel rerum cuder...</p>
              </div>

              <div class="post-item clearfix">
                <img src="assets/img/news-5.jpg" alt="">
                <h4><a href="#">Et dolores corrupti quae illo quod dolor</a></h4>
                <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
              </div>

            </div>

          </div>
        </div> End News & Updates -->

      </div><!-- End Right side columns -->

    </div>
  </section>




  <script>
    // Get the elements to be dynamically updated
    const titleElement = document.getElementById('sales-title');
    const salesAmountElement = document.getElementById('sales-amount');
    //const salesIncreaseElement = document.getElementById('sales-increase');
  
    // Add event listeners for each filter option
    document.getElementById('filter-today').addEventListener('click', () => {
      titleElement.innerHTML = 'Sales <span>| Today</span>';
      salesAmountElement.innerText = 'RM {{$totalsaleToday}}'; // Replace with actual sales data for today
      //salesIncreaseElement.innerText = '12%'; // Replace with actual data for today
    });
  
    document.getElementById('filter-yesterday').addEventListener('click', () => {
      titleElement.innerHTML = 'Sales <span>| Yesterday</span>';
      salesAmountElement.innerText = 'RM {{$totalsaleYesterday}}'; // Replace with actual sales data for yesterday
      //salesIncreaseElement.innerText = '8%'; // Replace with actual data for yesterday
    });
  
    document.getElementById('filter-month').addEventListener('click', () => {
      titleElement.innerHTML = 'Sales <span>| This Month</span>';
      salesAmountElement.innerText = 'RM {{$totalsaleMonth}}'; // Replace with actual sales data for the month
      //salesIncreaseElement.innerText = '15%'; // Replace with actual data for the month
    });
  
    document.getElementById('filter-year').addEventListener('click', () => {
      titleElement.innerHTML = 'Sales <span>| This Year</span>';
      salesAmountElement.innerText = 'RM {{$totalsaleYear}}'; // Replace with actual sales data for the year
      //salesIncreaseElement.innerText = '25%'; // Replace with actual data for the year
    });
  </script>

<script>
  // Get the elements to be dynamically updated
  const customertitleElement = document.getElementById('customer-title');
  const customercountElement = document.getElementById('customer-count');
  //const salesIncreaseElement = document.getElementById('sales-increase');

  // Add event listeners for each filter option
  document.getElementById('filter-today-customer').addEventListener('click', () => {
    customertitleElement.innerHTML = 'Customers <span>| Today</span>';
    customercountElement.innerText = '{{$customerCountToday}}'; // Replace with actual sales data for today
    //salesIncreaseElement.innerText = '12%'; // Replace with actual data for today
  });

  document.getElementById('filter-yesterday-customer').addEventListener('click', () => {
    customertitleElement.innerHTML = 'Customers <span>| Yesterday</span>';
    customercountElement.innerText = '{{$customerCountYesterday}}'; // Replace with actual sales data for yesterday
    //salesIncreaseElement.innerText = '8%'; // Replace with actual data for yesterday
  });

  document.getElementById('filter-month-customer').addEventListener('click', () => {
    customertitleElement.innerHTML = 'Customers <span>| This Month</span>';
    customercountElement.innerText = '{{$customerCountMonth}}'; // Replace with actual sales data for the month
    //salesIncreaseElement.innerText = '15%'; // Replace with actual data for the month
  });

  document.getElementById('filter-year-customer').addEventListener('click', () => {
    customertitleElement.innerHTML = 'Customers <span>| This Year</span>';
    customercountElement.innerText = '{{$customerCountYear}}'; // Replace with actual sales data for the year
    //salesIncreaseElement.innerText = '25%'; // Replace with actual data for the year
  });
</script>


@endsection