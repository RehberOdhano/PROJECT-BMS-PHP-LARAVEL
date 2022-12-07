@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Expense Titles')

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
                    <li class="breadcrumb-item active" aria-current="page">Expense Titles</li>
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
            <h2>Expense Titles</h2>
        </div>
    </div>
</section>
<section id="basic-datatable">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table zero-configuration">
                            <thead>
                                <tr>
                                    <th>Expense Title</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                <tr>
                                    <td>{{$expense["title"]}}</td>
                                    <td class="text-center py-1">
                                        <div class="dropup">
                                            <span
                                                class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                role="menu">
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href=""
                                                    data-target="#edit-expense-<?php echo $expense['id']; ?>"
                                                    data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                                                <a class="dropdown-item" id="confirm-text" href=""
                                                    data-target="#delete-<?php echo $expense['id']; ?>"
                                                    data-toggle="modal"><i class="bx bx-trash mr-1"></i> delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Edit expense Modal --}}
                                <div class="modal-success mr-1 mb-1 d-inline-block">
                                    <!--Success theme Modal -->
                                    <div class="modal fade text-left" id="edit-expense-<?php echo $expense['id']; ?>"
                                        tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
                                        aria-hidden="true">
                                        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success">
                                                    <h5 class="modal-title white" id="myModalLabel110">Edit Expense</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="expenseForm{{$expense['id']}}" class="form" method="POST"
                                                        action="{{URL('dists/admin/edit/expense/title/'.$expense['id'])}}">
                                                        @csrf
                                                        <div class="form-body">
                                                            <div class="row">
                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group form-field">
                                                                        <label for="title{{$expense['id']}}">Expense
                                                                            Title</label>
                                                                        <input type="text" id="title{{$expense['id']}}"
                                                                            class="form-control"
                                                                            value={{$expense["title"]}} name="exp_title"
                                                                            onkeyup="checkExpenseTitle(this)"
                                                                            onfocusout="checkInputField(this, {{$expense['id']}})">
                                                                        <small></small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 d-flex justify-content-end">
                                                                    <button
                                                                        onclick="submitExpenseForm({{$expense['id']}})"
                                                                        type="submit"
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
                                <div class="modal fade text-left" id="delete-<?php echo $expense['id']; ?>"
                                    tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h5 class="modal-title white" id="myModalLabel120">Confirm</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <form class="form"
                                                    action="{{URL('dists/admin/delete/expense/title/'.$expense['id'])}}"
                                                    method="POST">
                                                    @csrf
                                                    <div class="form-body">
                                                        <div class="row">
                                                            <div class="col-md-12 col-12">
                                                                <div class="form-label-group">
                                                                    <p style="font-size: 20px; font-weight: bold">Are
                                                                        you sure you want to delete this?
                                                                    </p>
                                                                    <input name="delete_dist" type="hidden"
                                                                        id="delete_dist" class="form-control"
                                                                        value="{{$expense['id']}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-flex justify-content-end">
                                                                <button type="submit"
                                                                    class="btn btn-danger mr-1">Delete</button>
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
                </div>
            </div>
        </div>
        <div class="col-4">
            <form id="expenseTitleForm" class="form" method="POST" action="{{URL('dists/admin/add/expense/title')}}">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group form-field">
                                <label for="exp-title">Expense Title</label>
                                <input type="text" id="exp-title" class="form-control" name="exp_title"
                                    placeholder="Expense Title...">
                                <small></small>
                                <button type="submit" style="margin-top: 4px; padding: 4px 15px;"
                                    class="btn btn-primary">Add Title</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
                    <form id="expenseTitleForm{{-1}}" class="form" action="/dists/admin/add/expense/title"
                        method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                        <label for="title{{-1}}">Expense Title</label>
                                        <input value="" type="text" id="title{{-1}}" class="form-control"
                                            placeholder="Expense Type" name="exp_title"
                                            onkeyup="checkExpenseTitle(this)"
                                            onfocusout="checkInputField(this, {{-1}})">
                                        <small></small>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button onclick="addExpenseTitle({{-1}})" class="btn btn-success mr-1">Add
                                        Title</button>
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
<script src="{{asset('js/addExpenseTitle.js')}}"></script>
<script>
    $('div.alert').delay(3000).slideUp(300);
    const checkInputField = (element, id) => {
        switch(element.id) {
            case "title" + id:
                checkExpenseTitle(element);
                break;
        }
    }
</script>


@endsection