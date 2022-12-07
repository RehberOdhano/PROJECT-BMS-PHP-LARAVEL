@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Expenses')

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
          <li class="breadcrumb-item active" aria-current="page">Expenses</li>
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
  @elseif(session('int-error'))
  <div class="alert alert-danger">
    {{Session::pull('int-error')}}
  </div>
  @endif
</section>
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Expenses</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Expense</span></button>
    </div>
  </div>
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Expense Title</th>
                  <th>Amount</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($expenses as $expense)
                <tr>
                  <td>{{date('d-m-Y', strtotime(substr($expense["date"], 0, 10)))}}</td>
                  <td>{{$expense["expense_title"]}}</td>
                  <td class="text-danger font-weight-bold text-align-left">Rs.{{$expense["amount"]}}</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-expense-<?php echo $expense['id']; ?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $expense['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>
                </tr>

                {{-- Edit expense Modal --}}
                <div class="modal-success mr-1 mb-1 d-inline-block">
                  <!--Success theme Modal -->
                  <div class="modal fade text-left" id="edit-expense-<?php echo $expense['id']; ?>" tabindex="-1"
                    role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header bg-success">
                          <h5 class="modal-title white" id="myModalLabel110">Edit Expense</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form id="expenseForm{{$expense['id']}}" class="form" method="POST"
                            action="{{URL('dists/admin/edit/expense/'.$expense['id'])}}">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="exp-title{{-1}}">Expense Title</label>
                                    @if($titles != null || !empty($titles))
                                    <select name="expTitle" id="expTitle{{-1}}" class="select2 form-control">
                                      <option selected disabled>Expense Titles</option>
                                      @foreach($titles as $title)
                                      <option id={{$title["id"]}} value="{{$title['title']}}">{{$title["title"]}}
                                      </option>
                                      @endforeach
                                    </select>
                                    @else
                                    <select class="select2 form-control">
                                      <option selected disabled>Expense Titles</option>
                                      <option value="Package Name">"NO TITLES"</option>
                                    </select>
                                    @endif
                                    <small></small>
                                  </div>
                                </div>
                                {{-- <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="title{{$expense['id']}}">Expense Title</label>
                                    <input type="text" id="title{{$expense['id']}}" class="form-control"
                                      value='{{$expense["expense_title"]}}' name="type"
                                      onkeyup="checkExpenseTitle(this)"
                                      onfocusout="checkInputField(this, {{$expense['id']}})">
                                    <small></small>
                                  </div>
                                </div> --}}
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="amount{{$expense['id']}}">Expense Amount</label>
                                    <input type="text" id="amount{{$expense['id']}}" class="form-control"
                                      value={{$expense["amount"]}} name="amount" onkeyup="checkExpenseAmount(this)"
                                      onfocusout="checkInputField(this, {{$expense['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                {{-- <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="purpose{{$expense['id']}}">Purpose</label>
                                    <input type="text" id="purpose{{$expense['id']}}" class="form-control"
                                      value="{{$expense['purpose']}}" name="purpose" onkeyup="checkExpensePurpose(this)"
                                      onfocusout="checkInputField(this, {{$expense['id']}})">
                                    <small></small>
                                  </div>
                                </div> --}}
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="date{{$expense['id']}}">Date</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                      <input name="date" type="date" id="date{{$expense['id']}}"
                                        class="form-control date_picker" value="{{$expense['date']}}"
                                        onchange="checkExpenseDate(this)" onclick="checkExpenseDate(this)"
                                        onfocusout="checkInputField(this, {{$expense['id']}})">
                                      <div class="form-control-position">
                                        <i class='bx bx-calendar'></i>
                                      </div>
                                      <small></small>
                                    </fieldset>
                                  </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                  <button onclick="submitExpenseForm({{$expense['id']}})" type="submit"
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

                {{-- delete expense modal --}}
                <div class="modal fade text-left" id="delete-<?php echo $expense['id']; ?>" tabindex="-1" role="dialog"
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
                        <form class="form" action="{{URL('dists/admin/delete/expense/'.$expense['id'])}}" method="POST">
                          @csrf
                          <div class="form-body">
                            <div class="row">
                              <div class="col-md-12 col-12">
                                <div class="form-label-group">
                                  <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                  </p>
                                  <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                    value="{{$expense['id']}}">
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
              </tbody>
            </table>
          </div>
          <hr class="mt-3">
          <div class="row mt-2" style="margin-left: 550px;">
            <div class="text-align:left;float:left; d-flex ml-4">
              <h5 style="font-weight: bold; font-size: 17px;">Total Expenses:</h5>
              <span class="ml-1 text-danger" style="font-weight: bold; font-size: 17px;">Rs.{{$total}}/-</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Add expense Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Expense</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="expenseForm{{-1}}" class="form" action="/dists/admin/add/expenses" method="POST">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="exp-title{{-1}}">Expense Title</label>
                    @if($titles != null || !empty($titles))
                    <select name="expTitle" id="exp-title{{-1}}" class="select2 form-control">
                      <option selected disabled>Expense Title</option>
                      @foreach($titles as $title)
                      <option value={{$title["title"] . "-" . $title["id"]}}>{{$title["title"]}}</option>
                      @endforeach
                    </select>
                    @else
                    <select id="exp-title{{-1}}" class="select2 form-control">
                      <option selected disabled>Expense Titles</option>
                      <option value="TITLES">"NO TITLES"</option>
                    </select>
                    @endif
                    <small></small>
                  </div>
                </div>
                {{-- <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="title{{-1}}">Expense Title</label>
                    <input type="text" id="title{{-1}}" class="form-control" placeholder="Expense Type" name="type"
                      onkeyup="checkExpenseTitle(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div> --}}
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="amount{{-1}}">Expense Amount</label>
                    <input type="text" id="amount{{-1}}" class="form-control" placeholder="Expense Amount" name="amount"
                      onkeyup="checkExpenseAmount(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                {{-- <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="purpose{{-1}}">Purpose</label>
                    <input type="text" id="purpose{{-1}}" class="form-control" placeholder="Purpose" name="purpose"
                      onkeyup="checkExpensePurpose(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div> --}}
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="date{{-1}}">Date</label>
                    <fieldset class="form-group position-relative has-icon-left">
                      <input name="date" type="date" id="date{{-1}}" class="form-control date_picker" placeholder="Date"
                        onchange="checkExpenseDate(this)" onclick="checkExpenseDate(this)"
                        onfocusout="checkInputField(this, {{-1}})">
                      <div class="form-control-position">
                        <i class='bx bx-calendar'></i>
                      </div>
                      <small></small>
                    </fieldset>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitExpenseForm({{-1}})" type="submit" class="btn btn-success mr-1">Add
                    Expense</button>
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
<script src="{{asset('js/addEditExpense.js')}}"></script>
<script src="{{asset('js/disableDates.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "title" + id:
        checkExpenseTitle(element);
        break;
      case "amount" + id:
        checkExpenseAmount(element);
        break;
      case "purpose" + id:
        checkExpensePurpose(element);
        break;
      case "date" + id:
        checkExpenseDate(element);
        break;
    }
  }
</script>


@endsection