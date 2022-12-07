@extends('layouts.super-admin.contentLayoutMaster')
{{-- title --}}
@section('title','Distributions')

{{-- page-styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/animate/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/login.css')}}">
@endsection

@section('content')
<!-- Knowledge base Jumbotron start -->
<section id="breadcrumb-rounded-divider" class="mb-2">
  <div class="row">
    <div class="col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded-pill breadcrumb-divider">
          <li class="breadcrumb-item"><a href="/superadmin/dashboard"><i class="bx bx-home"></i></a></li>
          <li class="breadcrumb-item active" aria-current="page">Payment</li>
        </ol>
      </nav>
    </div>
  </div>
  </div>
</section>
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Payments</h2>
      {{-- <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Payment</span></button> --}}
    </div>
  </div>
  @if(session('success'))
  <div class="alert alert-success">
    {{Session::pull('success')}}
  </div>
  @elseif(session('delete'))
  <div class="alert alert-danger">
    {{Session::pull('delete')}}
  </div>
  @elseif(session('update'))
  <div class="alert alert-primary">
    {{Session::pull('update')}}
  </div>
  @endif
</section>

<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header d-flex justify-content-between">
          <h2 class="card-title">Payment</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            {{-- <div class="col-md-6 col-12">
              <form action="/superadmin/payment/search">
                <div class="form-group">
                  <label class="text-bold-600" for="search">Search</label>
                  <input name="query" id="search" type="text" class="search_input" value="" autocomplete="search"
                    placeholder="Search payments here...">
                </div>
              </form>
            </div> --}}

            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Distribtution Name</th>
                  <th>Amount Paid</th>
                  <th>Due Amount</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($payments as $payment)
                <tr>
                  <td>{{$payment["dist_name"]}}</td>
                  <td>Rs.{{$payment["amount_paid"]}}</td>
                  @if($payment["due_amount"])
                  <td class="text-danger font-weight-bold text-center">Rs.{{$payment["due_amount"]}}</td>
                  @else
                  <td class="text-center">NIL</td>
                  @endif
                  <td>{{date('d-m-Y', strtotime($payment["date_amount_paid"]))}}</td>
                  @if($payment["status"] == 'Pending')
                  <td class="text-warning font-weight-bold text-uppercase text-left-align">{{$payment["status"]}}</td>
                  @else
                  <td class="text-success font-weight-bold text-uppercase text-left-align">{{$payment["status"]}}</td>
                  @endif
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/superadmin/payments/edit/{{$payment['id']}}"
                          data-target="#edit-stock-<?php echo $payment['id']; ?>" data-toggle="modal"><i
                            class="bx bx-edit-alt mr-1"></i> edit</a>
                      </div>
                    </div>
                  </td>
                </tr>

                {{-- Edit Payment Modal --}}
                <div class="modal-success mr-1 mb-1 d-inline-block">
                  <!--Success theme Modal -->
                  <div class="modal fade text-left" id="edit-stock-<?php echo $payment['id']; ?>" tabindex="-1"
                    role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header bg-success">
                          <h5 class="modal-title white" id="myModalLabel110">Edit Payment</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                          </button>
                        </div>
                        <div class="modal-body" style="overflow-y: hidden;">
                          <form id="distPaymentForm{{$payment['id']}}" class="form" method="POST"
                            action="{{URL('/superadmin/payments/edit/'.$payment['id'])}}">
                            @csrf
                            <div class="h-100 m-0 form-body d-flex flex-column justify-content-around">
                              <div class="row">
                                <div class="col-md-6 col-12">
                                  <div class="form-group form-field">
                                    <label class="text-bold-600" for="amountPaid{{$payment['id']}}">Amount Paid</label>
                                    <input id="amountPaid{{$payment['id']}}" type="text" class="form-control"
                                      name="amount_paid" value={{$payment["amount_paid"]}} autocomplete="amount_paid"
                                      onkeyup="checkAmountPaid(this)"
                                      onfocusout="checkInputField(this, {{$payment['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group form-field">
                                    <label class="text-bold-600" for="amountDue{{$payment['id']}}">Amount Due</label>
                                    <input id="amountDue{{$payment['id']}}" type="text" class="form-control"
                                      name="amount_due" value={{$payment["due_amount"]}} autocomplete="amount_due"
                                      onkeyup="checkAmountDue(this, {{$payment['id']}})"
                                      onfocusout="checkInputField(this, {{$payment['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group form-field">
                                    <label for="status{{$payment['id']}}">Status</label>
                                    <input type="text" disabled id="status{{$payment['id']}}" value=""
                                      class="form-control" placeholder="Status" name="status"
                                      onchange="checkStatus(this)"
                                      onfocusout="checkInputField(this, {{$payment['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group form-field">
                                    <label for="payment_date{{$payment['id']}}">Payment Date</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                      <input name="payment_date" type="date" id="payment_date{{$payment['id']}}"
                                        class="form-control date_picker" value="{{$payment['date_amount_paid']}}"
                                        onkeyup="checkPaymentDate(this)"
                                        onfocusout="checkInputField(this, {{$payment['id']}})">
                                      <div class="form-control-position">
                                        <i class='bx bx-calendar'></i>
                                      </div>
                                      <small></small>
                                    </fieldset>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                  <button onclick="submitDistPaymentForm({{$payment['id']}})" type="submit"
                                    class="btn btn-success mr-1">Update</button>
                                  <button type="reset" class="btn btn-light-secondary"
                                    data-dismiss="modal">Cancel</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                {{-- <div class="modal fade text-left" id="delete" tabindex="-1" role="dialog"
                  aria-labelledby="myModalLabel120" aria-hidden="true">
                  <form method="POST" action="{{URL('/superadmin/payments/delete/'.$payment['id'])}}">
                    @csrf
                    <input type="hidden" name="" value="{{$payment['id']}}" />
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header bg-danger">
                          <h5 class="modal-title white" id="myModalLabel120">Confirm</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                          </button>
                        </div>
                        <div class="modal-body text-center">
                          <p style="font-size: 20px; font-weight: bold">
                            Are you sure you want to delete this?
                          </p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Cancel</span>
                          </button>
                          <button type="submit" class="btn btn-danger ml-1" data-dismiss="modal">
                            <i class="bx bx-trash-can d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Yes Delete</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div> --}}
                @endforeach
              </tbody>
              {{-- <tfoot>
                <tr>
                  <th>Amount Paid</th>
                  <th>Due Amount</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </tfoot> --}}
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

{{-- page scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{asset('vendors/js/pickers/pickadate/legacy.js')}}"></script>
<script src="{{asset('vendors/js/extensions/moment.min.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
{{-- Custom JS --}}
<script src="{{asset('/js/search.js')}}"></script>

@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/forms/number-input.js')}}"></script>
<script src="{{asset('js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>
<script src="{{asset('js/scripts/extensions/sweet-alerts.js')}}"></script>
<script src="{{asset('js/addEditPayment.js')}}"></script>
<script src="{{asset('js/disableDates.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "amountPaid" + id:
        checkAmountPaid(element);
        break;
      case "amountDue" + id:
        checkAmountDue(element, id);
        break;
      case "status" + id:
        checkStatus(element);
        break;
    }
  }
</script>


@endsection