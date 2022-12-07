@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Suppliers')

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
          <li class="breadcrumb-item active" aria-current="page">Suppliers</li>
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
      <h2>Suppliers</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Supplier</span></button>
    </div>
  </div>
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header">
          <h2 class="card-title">Suppliers</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>Supplier Since</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($suppliers as $supplier)
                <tr>
                  <td>{{$supplier["name"]}}</td>
                  <td>{{$supplier["contact"]}}</td>
                  <td>{{$supplier["address"]}}</td>
                  <td>{{date('d-m-Y', strtotime($supplier["supplier_since"]))}}</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-Suppliers-<?php echo $supplier['id']; ?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $supplier['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>

                  {{-- Edit Suppliers Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="edit-Suppliers-<?php echo $supplier['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Edit Suppliers</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="supplierForm{{$supplier['id']}}" class="form"
                              action="{{URL('/dists/admin/edit/supplier/'.$supplier['id'])}}" method="POST">
                              @csrf
                              <div class="form-body m-0 d-flex flex-column justify-content-around">
                                <div class="row">
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="name{{$supplier['id']}}">Supplier Name</label>
                                      <input type="text" id="name{{$supplier['id']}}" class="form-control"
                                        value='{{$supplier["name"]}}' name="name" onkeyup="checkSupplierName(this)"
                                        onfocusout="checkInputField(this, {{$supplier['id']}})">
                                      <small><small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="contact{{$supplier['id']}}">Supplier Contact</label>
                                      <input style="width: 470px;" type="text" id="contact{{$supplier['id']}}"
                                        class="form-control" value={{$supplier["contact"]}} name="contact"
                                        onkeyup="checkSupplierContact(this)"
                                        onfocusout="checkInputField(this, {{$supplier['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="address{{$supplier['id']}}">Supplier Address</label>
                                      <input style="width: 470px;" type="text" id="address{{$supplier['id']}}"
                                        class="form-control" value="{{$supplier['address']}}" name="address"
                                        onkeyup="checkSupplierAddress(this)"
                                        onfocusout="checkInputField(this, {{$supplier['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="date{{$supplier['id']}}">Supplier Since</label>
                                      <fieldset class="form-group position-relative has-icon-left">
                                        <input style="width: 470px;" name="date" type="date"
                                          id="date{{$supplier['id']}}" class="form-control date_picker"
                                          value="{{$supplier['supplier_since']}}" onchange="checkSupplierJoinDate(this)"
                                          onclick="checkSupplierJoinDate(this)"
                                          onfocusout="checkInputField(this, {{$supplier['id']}})">
                                        <div class="form-control-position">
                                          <i class='bx bx-calendar'></i>
                                        </div>
                                        <small></small>
                                      </fieldset>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-7"></div>
                                    <div class="col-12" style="length: 100%; display: flex; justify-content: flex-end;">
                                      <button onclick="submitSupplierForm({{$supplier['id']}})" type="submit"
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

                  {{-- delete supplier modal --}}
                  <div class="modal fade text-left" id="delete-<?php echo $supplier['id']; ?>" tabindex="-1"
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
                          <form class="form" action="{{URL('/dists/admin/delete/supplier/'.$supplier['id'])}}"
                            method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                    </p>
                                    <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                      value="{{$supplier['id']}}">
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

{{-- Add Suppliers Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="supplierForm{{-1}}" class="form" method="POST" action="/dists/admin/add/supplier">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="name{{-1}}">Supplier Name</label>
                    <input type="text" id="name{{-1}}" class="form-control" placeholder="Supplier Name" name="name"
                      onkeyup="checkSupplierName(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="contact{{-1}}">Supplier Contact</label>
                    <input type="text" id="contact{{-1}}" class="form-control" placeholder="Supplier Contact"
                      name="contact" onkeyup="checkSupplierContact(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="address{{-1}}">Supplier Address</label>
                    <input type="text" id="address{{-1}}" class="form-control" placeholder="Supplier Address"
                      name="address" onkeyup="checkSupplierAddress(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="date{{-1}}">Supplier Since</label>
                    <fieldset class="form-group position-relative has-icon-left">
                      <input name="date" type="date" id="date{{-1}}" class="form-control date_picker"
                        placeholder="Joining Date" onchange="checkSupplierJoinDate(this)"
                        onclick="checkSupplierJoinDate(this)" onfocusout="checkInputField(this, {{-1}})">
                      <div class="form-control-position">
                        <i class='bx bx-calendar'></i>
                      </div>
                      <small></small>
                    </fieldset>
                  </div>
                </div>

                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitSupplierForm({{-1}})" type="submit" class="btn btn-success mr-1">Add
                    Supplier</button>
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
<script src="{{asset('js/addEditSupplier.js')}}"></script>
<script src="{{asset('js/disableDates.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "name" + id:
        checkSupplierName(element);
        break;
      case "contact" + id:
        checkSupplierContact(element);
        break;
      case "address" + id:
        checkSupplierAddress(element);
        break;
      case "date" + id:
        checkSupplierJoinDate(element);
        break;
    }
  }
</script>


@endsection