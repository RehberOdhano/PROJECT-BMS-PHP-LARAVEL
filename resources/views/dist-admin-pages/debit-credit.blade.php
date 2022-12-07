@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Debit-Credit')

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
  integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')
<!-- Knowledge base Jumbotron start -->
<section id="breadcrumb-rounded-divider" class="mb-2">
  <div class="row">
    <div class="col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded-pill breadcrumb-divider">
          <li class="breadcrumb-item"><a href="/dists/admin/dashboard"><i class="bx bx-home"></i></a></li>
          <li class="breadcrumb-item active" aria-current="page">Debits/Credits</li>
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
      <h2>Debits/Credits</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Debit/Credit</span></button>
    </div>
  </div>
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header">
          <h2 class="card-title">Debits/Credits</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Debit Amount</th>
                  <th>Credit Amount</th>
                  {{-- <th>Balance</th> --}}
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($debitCredits as $debitCredit)
                <tr>
                  <td>{{date('d-m-Y', strtotime(substr($debitCredit["date"], 0, 10)))}}</td>
                  <td>{{$debitCredit["description"]}}</td>
                  @if($debitCredit["debit"] == null)
                  <td class="text-center">NIL</td>
                  @elseif($debitCredit["debit"] != null)
                  <td class="text-success font-weight-bold text-center">Rs.{{$debitCredit["debit"]}}</td>
                  @endif
                  @if($debitCredit["credit"] == null)
                  <td class="text-center">NIL</td>
                  @else
                  <td class="text-danger font-weight-bold text-center
                        text-center">Rs.{{$debitCredit["credit"]}}</td>
                  @endif
                  {{-- <td class="font-weight-bold">Rs.{{$debitCredit["balance"]}}</td> --}}
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href=""
                          data-target="#edit-debit-credit-<?php echo $debitCredit['id']; ?>" data-toggle="modal"><i
                            class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $debitCredit['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>
                </tr>

                {{-- Edit Debit/Credit Modal --}}
                <div class="modal-success mr-1 mb-1 d-inline-block">
                  <!--Success theme Modal -->
                  <div class="modal fade text-left" id="edit-debit-credit-<?php echo $debitCredit['id']; ?>"
                    tabindex="-1" role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header bg-success">
                          <h5 class="modal-title white" id="myModalLabel110">Edit Debit/Credit</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form id="debitCreditForm{{$debitCredit['id']}}" class="form" method="POST"
                            action="{{URL('dists/admin/edit/debit-credit/'.$debitCredit['id'])}}">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="description{{$debitCredit['id']}}">Description</label>
                                    <input disabled type="text" id="description{{$debitCredit['id']}}"
                                      class="form-control" value="{{$debitCredit['description']}}" name="description"
                                      onkeyup="checkDescription(this)"
                                      onfocusout="checkInputField(this, {{$debitCredit['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-12 col-12">
                                  <div id="radiobtns{{$debitCredit['id']}}" class="form-group form-field">
                                    <label>Choose one option:</label><br>
                                    @if($debitCredit['debit'] != 0)
                                    <input checked disabled onclick="showInput(this,{{$debitCredit['id']}})"
                                      type="radio" id="debit-radio{{$debitCredit['id']}}" name="debitCreditAmount"
                                      value="checked-{{$debitCredit['debit']}}">
                                    <label for="debit">Debit Amount</label><br>
                                    <input disabled onclick="showInput(this,{{$debitCredit['id']}})" type="radio"
                                      id="credit-radio{{$debitCredit['id']}}" name="debitCreditAmount" value="">
                                    <label for="credit">Credit Amount</label><br>
                                    <small></small>
                                    @else
                                    <input disabled onclick="showInput(this,{{$debitCredit['id']}})" type="radio"
                                      id="debit-radio{{$debitCredit['id']}}" name="debitCreditAmount" value="">
                                    <label for="debit">Debit Amount</label><br>
                                    <input checked disabled onclick="showInput(this,{{$debitCredit['id']}})"
                                      type="radio" id="credit-radio{{$debitCredit['id']}}" name="debitCreditAmount"
                                      value="checked-{{$debitCredit['credit']}}">
                                    <label for="credit">Credit Amount</label><br>
                                    <small></small>
                                    @endif
                                  </div>
                                  <div class="col-md-12 col-12" style="max-width: 100%!important;">
                                    <div id="debitCreditInput{{$debitCredit['id']}}" class="form-group form-field">
                                      <input style="display: none; width: 100%;" type="text" name="" id=""
                                        onkeyup="checkDebitCreditAmount(this, {{$debitCredit['id']}})"
                                        onfocusout="checkInputField(this, {{$debitCredit['id']}})">
                                      <small></small>
                                      <br>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="date{{$debitCredit['id']}}">Date</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                      <input name="date" type="date" id="date{{$debitCredit['id']}}"
                                        class="form-control date_picker" value="{{$debitCredit['date']}}"
                                        onchange="checkDate(this,{{$debitCredit['id']}})"
                                        onclick="checkDate(this,{{$debitCredit['id']}})"
                                        onfocusout="checkInputField(this, {{$debitCredit['id']}})">
                                      <div class="form-control-position">
                                        <i class='bx bx-calendar'></i>
                                      </div>
                                      <small></small>
                                    </fieldset>
                                  </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                  <button onclick="submitDebitCreditForm({{$debitCredit['id']}})" type="submit"
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

                {{-- delete modal --}}
                <div class="modal fade text-left" id="delete-<?php echo $debitCredit['id']; ?>" tabindex="-1"
                  role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header bg-danger">
                        <h5 class="modal-title white" id="myModalLabel120">Confirm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <i class="bx bx-x"></i>
                        </button>
                      </div>
                      <div class="modal-body text-center">
                        <form class="form" action="{{URL('dists/admin/delete/debit-credit/'.$debitCredit['id'])}}"
                          method="POST">
                          @csrf
                          <div class="form-body">
                            <div class="row">
                              <div class="col-md-12 col-12">
                                <div class="form-label-group">
                                  <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                  </p>
                                  <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                    value="{{$debitCredit['id']}}">
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
                @endforeach
            </table>
          </div>
          <hr class="mt-3">
          <div class="row mt-2 justify-content-center">
            <div class="text-align:left;float:left; d-flex ml-4">
              <h5 style="font-weight: bold; font-size: 17px;">Total Debit:</h5>
              <span class="ml-1 text-success"
                style="font-weight: bold; font-size: 17px;">Rs.{{$totalDebitAmount}}/-</span>
            </div>
            <div class="text-align:left;float:left; d-flex ml-4">
              <h5 style="font-weight: bold; font-size: 17px;">Total Credit:</h5>
              <span class="ml-1 text-danger"
                style="font-weight: bold; font-size: 17px;">Rs.{{$totalCreditAmount}}/-</span>
            </div>
            <div class="text-align:left;float:left; d-flex ml-4">
              <h5 style="font-weight: bold; font-size: 17px;">Total Balance:</h5>
              <span class="ml-1" style="font-weight: bold; font-size: 17px;">Rs.{{$totalBalance}}/-</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Add Debit Credit Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Debit/Credit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="debitCreditForm{{-1}}" class="form" method="POST" action="/dists/admin/add/debit-credit">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="description{{-1}}">Description</label>
                    <input type="text" id="description{{-1}}" value="" class="form-control" placeholder="Description"
                      name="description" onkeyup="checkDescription(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div id="radiobtns{{-1}}" class="form-group form-field">
                    <label>Choose one option:</label><br>
                    <input onclick="showInput(this,-1)" type="radio" id="debit-radio{{-1}}" name="debitCreditAmount"
                      value="">
                    <label for="debit">Debit Amount</label><br>
                    <input onclick="showInput(this,-1)" type="radio" id="credit-radio{{-1}}" name="debitCreditAmount"
                      value="">
                    <label for="credit">Credit Amount</label><br>
                    <small></small>
                  </div>
                  <div class="col-md-12 col-12" style="max-width: 100%!important;">
                    <div id="debitCreditInput{{-1}}" class="form-group form-field">
                      <input style="display: none; width: 100%;" type="text" name="" id=""
                        onkeyup="checkDebitCreditAmount(this, -1)" onfocusout="checkInputField(this, {{-1}})">
                      <small></small>
                      <br>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="date{{-1}}">Date</label>
                    <fieldset class="form-group position-relative has-icon-left">
                      <input name="date" type="date" id="date{{-1}}" value="" class="form-control date_picker"
                        placeholder="Date" onchange="checkDate(this,-1)" onclick="checkDate(this,-1)"
                        onfocusout="checkInputField(this, {{-1}})">
                      <div class="form-control-position">
                        <i class='bx bx-calendar'></i>
                      </div>
                      <small></small>
                    </fieldset>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitDebitCreditForm({{-1}})" type="submit" class="btn btn-success mr-1">Add
                    Debit/Credit</button>
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
<script src="{{asset('/js/addEditDebitCredit.js')}}"></script>
<script src="{{asset('/js/disableDates.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  var input = $('input[name="debitCreditAmount"]');
  for(let i = 0; i < input.length; i++) {
    if(input[i].value.includes("checked")) {
      const pattern = /[0-9]/g;
      var id = input[i].getAttribute('id').match(pattern).join('');
      const parent = document.getElementById("debitCreditInput" + id);
      const amount = parent.childNodes[1];
      amount.style.display = "inline-block";
      amount.setAttribute("name", input[i].id.split("-")[0]);
      amount.setAttribute("id", "newInput" + id);
      amount.setAttribute("value", input[i].value.split("-")[1]); 
    }
  }
  
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "description" + id:
        checkDescription(element);
        break;
      case "debit" + id:
        checkDebitCreditAmount(element, id);
        break;
      case "credit" + id:
        checkDebitCreditAmount(element, id);
        break;
      case "newInput" + id:
        checkDebitCreditAmount(element, id);
        break;
      case "date" + id:
        checkDate(element);
        break;
    //   case "balance" + id:
    //     checkBalance(element);
    //     break;
    }
  }
</script>
@endsection