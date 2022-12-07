@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Ledger Details')

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
          <li class="breadcrumb-item"><a href="/dists/admin/dashboard"><i class="bx bx-home"></i></a></li>
          <li class="breadcrumb-item active" aria-current="page">Ledger Details</li>
        </ol>
      </nav>
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
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Ledger Details</h2>
      {{-- <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Ledger</span></button> --}}
    </div>
  </div>
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header d-flex justify-content-between">
          <h2 class="card-title">Sales</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Outlet</th>
                  <th>Salesman</th>
                  <th>Total Amount</th>
                  <th>Amount Paid</th>
                  <th>Due Amount</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($details as $detail)
                <tr>
                  <td>{{date('d-m-Y', strtotime(substr($detail["created_at"], 0, 10)))}}</td>
                  <td>{{$detail["outlet"]}}</td>
                  <td>{{$detail["salesman"]}}</td>
                  <td class="text-success font-weight-bold text-center">Rs.{{$detail["total_amount"]}}</td>
                  <td class="text-success font-weight-bold text-center">Rs.{{$detail["amount_paid"]}}</td>
                  <td class="text-danger font-weight-bold text-center">Rs.{{$detail["amount_due"]}}</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-ledger-<?php echo $detail['id']; ?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        {{-- <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $detail['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a> --}}
                      </div>
                    </div>
                  </td>

                  {{-- Edit Ledger Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="edit-ledger-<?php echo $detail['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content" style="width: 600px;">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Edit Ledger</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body" style="overflow-y: hidden;">
                            <form id="ledgerForm{{$detail['id']}}" class="form" method="POST"
                              action="{{URL('/dists/admin/ledger/update/'.$detail['sale_id'])}}">
                              @csrf
                              <div class="form-body">
                                <div class="row" style="top: -70px;">
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="totalAmount{{$detail['id']}}">Total Amount</label>
                                      <input disabled type="text" id="totalAmount{{$detail['id']}}" class="form-control"
                                        value="{{$detail['total_amount']}}" name="totalAmount" onkeyup="checkLedgerTotalAmount(this)"
                                        onfocusout="checkInputField(this, {{$detail['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="amountPaid{{$detail['id']}}">Amount Paid</label>
                                      <input type="text" id="amountPaid{{$detail['id']}}" class="form-control"
                                        value="{{$detail['amount_paid']}}" name="amountPaid" onkeyup="checkLedgerAmountPaid(this); calcDueAmount(this);"
                                        onfocusout="checkInputField(this, {{$detail['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="dueAmount{{$detail['id']}}">Amount Due</label>
                                      <input disabled type="text" id="dueAmount{{$detail['id']}}" class="form-control"
                                        value="{{$detail['amount_due']}}" name="amountDue" onkeyup="checkLedgerAmountDue(this)"
                                        onfocusout="checkInputField(this, {{$detail['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="row col-md-12 col-12">
                                    <div class="col-7"></div>
                                    <div class="col-5 d-flex">
                                      <button onclick="submitLedgerForm({{$detail['id']}})" type="submit"
                                        class="btn btn-success mr-1">Update</button>
                                      <button type="reset" class="btn btn-light-secondary"
                                        data-dismiss="modal">Cancel</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  {{-- DELETE MODAL --}}
                  <div class="modal fade text-left" id="delete-<?php echo $detail['id']; ?>" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel120" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header bg-danger">
                          <h5 class="modal-title white" id="myModalLabel120">Confirm</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                          </button>
                        </div>
                        <div class="modal-body text-center">
                          <form class="form" action="{{URL('/dists/admin/ledger/delete/'.$detail['id'])}}"
                            method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                    </p>
                                    <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                      value="{{$detail['id']}}">
                                  </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                  <button type="submit" class="btn btn-danger mr-1">Delete</button>
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
                </tr>
                @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Add Ledger Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Ledger</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="ledgerForm{{-1}}" class="form" method="POST" action="{{URL('/dists/admin/ledger/add')}}">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-12 col-12">
                  <label for="description{{-1}}">Description</label>
                  <div class="form-group form-field">
                    <input type="text" id="description{{-1}}" class="form-control" placeholder="Description"
                      name="description" onkeyup="checkDescription(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="pay_method{{-1}}">Payment Method</label>
                    <input type="text" id="pay_method{{-1}}" class="form-control" placeholder="Payment Method"
                      name="pay_method" onkeyup="checkPaymentMethod(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <label for="out{{-1}}">Out</label>
                  <div class="form-group form-field">
                    <input type="text" id="out{{-1}}" class="form-control" placeholder="Out" name="out"
                      onkeyup="checkLedgerAmountOut(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <label for="in{{-1}}">In</label>
                  <div class="form-group form-field">
                    <input type="text" id="in{{-1}}" class="form-control" placeholder="In" name="in"
                      onkeyup="checkLedgerAmountIn(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group">
                    <label for="date{{-1}}">Date</label>
                    <fieldset class="form-group position-relative has-icon-left">
                      <input id="date{{-1}}" type="date" name="date" class="form-control date_picker" placeholder="Date"
                        onchange="checkDate(this)" onclick="checkDate(this)" onfocusout="checkInputField(this, {{-1}})">
                      <div class="form-control-position">
                        <i class='bx bx-calendar'></i>
                      </div>
                      <small></small>
                    </fieldset>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitLedgerForm({{-1}})" type="submit" class="btn btn-success mr-1">Add
                    Ledger</button>
                  <button type="reset" class="btn btn-light-secondary" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
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

@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/forms/number-input.js')}}"></script>
<script src="{{asset('js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>
<script src="{{asset('js/scripts/extensions/sweet-alerts.js')}}"></script>
<script src="{{asset('js/addEditLedger.js')}}"></script>
<script src="{{asset('js/disableDates.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "description" + id:
        checkDescription(element);
        break;
      case "pay_method" + id:
        checkPaymentMethod(element);
        break;
      case "in" + id:
        checkLedgerAmountIn(element);
        break;
      case "out" + id:
        checkLedgerAmountOut(element);
        break;
      case "date" + id:
        checkDate(element);
        break;
    }
  }
</script>


@endsection