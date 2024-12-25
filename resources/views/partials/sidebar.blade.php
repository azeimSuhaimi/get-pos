<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link {{ Request::is('dashboard')  ? '':'collapsed' }}" href="{{route('dashboard')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link {{ (Request::is('pos') || Request::is('pos_searching_item')) || ((Request::is('pos_suspend_view') || Request::is('invoice')) || Request::is('invoice_receipt')) || (Request::is('invoice_digital_method') || Request::is('invoice_add_member_digital')) || ((Request::is('invoice_add_member_cash') || Request::is('invoice_cash_method')) || Request::is('invoice_cash_method')) || (Request::is('invoice_add_member_hybrid') || Request::is('invoice_hybrid_method')) || ((Request::is('invoice_toyyibpay_method') || Request::is('invoice_add_member_toyyibpay')) || Request::is('invoice_cash_method')) ? '':'collapsed' }}" href="{{route('pos')}}">
        <i class="bi bi-grid"></i>
        <span>P.O.S</span>
      </a>
    </li><!-- End pos Nav -->

    <li class="nav-item">
      <a class="nav-link {{ (Request::is('receipt') || Request::is('receipt_view')) || ((Request::is('receipt_view') || Request::is('receipt_view')) || Request::is('receipt_view'))  ? '':'collapsed' }}" href="{{route('receipt')}}">
        <i class="bi bi-grid"></i>
        <span>Receipt</span>
      </a>
    </li><!-- End  Nav -->

    <li class="nav-item">
      <a class="nav-link {{ (Request::is('list_online_manual') || Request::is('invoice_online_manual')) || ((Request::is('invoice_online_manual') || Request::is('invoice_online_manual')) || Request::is('invoice_online_manual')) ? '':'collapsed' }}" href="{{route('invoice.list_online_manual')}}">
        <i class="bi bi-grid"></i>
        <span>Online Manual</span>
      </a>
    </li><!-- End item Nav -->

    <li class="nav-item">
      <a class="nav-link {{ (Request::is('invoice_void') || Request::is('invoice_void_view')) || ((Request::is('invoice_void_list_view') || Request::is('invoice_void_list')) || Request::is('invoice_void_view'))  ? '':'collapsed' }}" href="{{route('invoice_void')}}">
        <i class="bi bi-grid"></i>
        <span>Void</span>
      </a>
    </li><!-- End  Nav -->

    <li class="nav-item">
      <a class="nav-link {{ (Request::is('expense_create') || Request::is('expense')) || ((Request::is('expense_view') || Request::is('expense_edit')) || Request::is('expense_edit'))  ? '':'collapsed' }}" href="{{route('expense')}}">
        <i class="bi bi-grid"></i>
        <span>Expense</span>
      </a>
    </li><!-- End  Nav -->

    <li class="nav-item">
      <a class="nav-link {{ (Request::is('customer_order') || Request::is('customer_order_create')) || ((Request::is('customer_order_view') || Request::is('customer_order_edit')) || Request::is('customer_order'))  ? '':'collapsed' }}" href="{{route('customer_order')}}">
        <i class="bi bi-grid"></i>
        <span>Customer Order</span>
      </a>
    </li><!-- End  Nav -->


    <li class="nav-item">
      <a class="nav-link {{ (Request::is('dailysalereport') || Request::is('dailysalereport')) || ((Request::is('dailysalereport') || Request::is('dailysalereport')) || Request::is('dailysalereport'))  ? '':'collapsed' }}" href="{{route('daily.sale.report')}}">
        <i class="bi bi-grid"></i>
        <span>Daily Sale Report</span>
      </a>
    </li><!-- End  Nav -->

    


    <li class="nav-item">
      <a class="nav-link {{ (Request::is('employee') || Request::is('employee_create')) || ((Request::is('employee_edit') || Request::is('employee_view')) || Request::is('employee')) ? '':'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Employee</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content {{ (Request::is('employee') || Request::is('employee_create')) || ((Request::is('employee_edit') || Request::is('employee_view')) || Request::is('employee')) ? '':'collapse' }}  " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{route('employee')}}" class=" {{ (Request::is('employee') || Request::is('employee_edit')) || ((Request::is('employee_view') || Request::is('employee')) || Request::is('employee')) ? 'active':'' }}">
            <i class="bi bi-circle"></i><span>All Employee</span>
          </a>
        </li>
        <li>
          <a href="{{route('employee.create')}}" class=" {{ Request::is('employee_create')  ? 'active':'' }}">
            <i class="bi bi-circle"></i><span>Create Employee</span>
          </a>
        </li>
      </ul>
    </li><!-- End Forms Nav -->


    <li class="nav-item">
      <a class="nav-link {{ (Request::is('customer') || Request::is('customer_view')) || ((Request::is('customer_edit') || Request::is('customer_purchase_detail')) || Request::is('customer')) ? '':'collapsed' }}" href="{{route('customer')}}">
        <i class="bi bi-grid"></i>
        <span>Customer</span>
      </a>
    </li><!-- End customers Nav -->

    <li class="nav-item">
      <a class="nav-link {{ (Request::is('item') || Request::is('item_view')) || ((Request::is('item_edit') || Request::is('item_create')) || Request::is('item')) ? '':'collapsed' }}" href="{{route('item')}}">
        <i class="bi bi-grid"></i>
        <span>Items</span>
      </a>
    </li><!-- End item Nav -->








  </ul>