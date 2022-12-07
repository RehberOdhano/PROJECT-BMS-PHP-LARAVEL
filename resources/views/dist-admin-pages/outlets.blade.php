@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Outlets')

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
          <li class="breadcrumb-item active" aria-current="page">Outlets</li>
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
  @elseif(session('error'))
  <div class="alert alert-danger">
    {{Session::pull('error')}}
  </div>
  @endif
</section>
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Outlets</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Outlet</span></button>
    </div>
  </div>
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header">
          <h2 class="card-title">Outlets</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>Route</th>
                  <th>Member Since</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($outlets as $outlet)
                <tr>
                  <td>{{$outlet["name"]}}</td>
                  <td>{{$outlet["contact"]}}</td>
                  <td>{{$outlet["address"]}}</td>
                  <td>{{$outlet["route"]}}</td>
                  <td>{{date('d-m-Y', strtotime(substr($outlet["created_at"], 0, 10)))}}</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-Suppliers-<?php echo $outlet['id']; ?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $outlet['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>

                  {{-- Edit outlets Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="edit-Suppliers-<?php echo $outlet['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Edit Outlet</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="outletForm{{$outlet['id']}}" class="form"
                              action="{{URL('/dists/admin/edit/outlet/'.$outlet['id'])}}" method="POST">
                              @csrf
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="name{{$outlet['id']}}">Outlet Name</label>
                                      <input type="text" id="name{{$outlet['id']}}" class="form-control"
                                        value="{{$outlet['name']}}" name="name" onkeyup="checkOutletName(this)"
                                        onfocusout="checkInputField(this, {{$outlet['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="contact{{$outlet['id']}}">Outlet Contact</label>
                                      <input type="text" id="contact{{$outlet['id']}}" class="form-control"
                                        value={{$outlet["contact"]}} name="contact" onkeyup="checkOutletContact(this)"
                                        onfocusout="checkInputField(this, {{$outlet['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="address{{$outlet['id']}}">Outlet Address</label>
                                      <input type="text" id="address{{$outlet['id']}}" class="form-control"
                                        value="{{$outlet['address']}}" name="address" onkeyup="checkOutletAddress(this)"
                                        onfocusout="checkInputField(this, {{$outlet['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="route{{$outlet['id']}}">Outlet Route</label>
                                      <input type="text" id="route{{$outlet['id']}}" class="form-control"
                                        value="{{$outlet['route']}}" name="route" onkeyup="checkOutletRoute(this)"
                                        onfocusout="checkInputField(this, {{$outlet['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="date{{$outlet['id']}}">Member Since</label>
                                      <fieldset class="form-group position-relative has-icon-left">
                                        <input name="date" type="date" id="date{{$outlet['id']}}"
                                          class="form-control date_picker" value="{{$outlet['member_since']}}"
                                          onchange="checkOutletDate(this)" onclick="checkOutletDate(this)"
                                          onkeyup="checkOutletDate(this)"
                                          onfocusout="checkInputField(this, {{$outlet['id']}})">
                                        <div class="form-control-position">
                                          <i class='bx bx-calendar'></i>
                                        </div>
                                        <small></small>
                                      </fieldset>
                                    </div>
                                  </div>
                                  <div class="col-12 d-flex justify-content-end">
                                    <button onclick="submitOutletForm({{$outlet['id']}})" type="submit"
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

                  {{-- delete supplier modal --}}
                  <div class="modal fade text-left" id="delete-<?php echo $outlet['id']; ?>" tabindex="-1" role="dialog"
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
                          <form class="form" action="{{URL('/dists/admin/delete/outlet/'.$outlet['id'])}}"
                            method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                    </p>
                                    <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                      value="{{$outlet['id']}}">
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
                {{--
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>Supplier Since</th>
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

{{-- Add Suppliers Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Outlet</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="outletForm{{-1}}" class="form" method="POST" action="/dists/admin/add/outlet">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="name{{-1}}">Outlet Name</label>
                    <input type="text" id="name{{-1}}" class="form-control" placeholder="Outlet Name" name="name"
                      onkeyup="checkOutletName(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="contact{{-1}}">Outlet Contact</label>
                    <input type="text" id="contact{{-1}}" class="form-control" placeholder="Outlet Contact"
                      name="contact" onkeyup="checkOutletContact(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="address{{-1}}">Outlet Address</label>
                    <input type="text" id="address{{-1}}" class="form-control" placeholder="Outlet Address"
                      name="address" onkeyup="checkOutletAddress(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="route{{-1}}">Outlet Route</label>
                    <input type="text" id="route{{-1}}" class="form-control" placeholder="Outlet Route" name="route"
                      onkeyup="checkOutletRoute(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group">
                    <label for="date{{-1}}">Member Since</label>
                    <fieldset class="form-group position-relative has-icon-left">
                      <input name="date" type="date" id="date{{-1}}" class="form-control date_picker"
                        placeholder="Membership Date" onkeyup="checkOutletDate(this)"
                        onfocusout="checkInputField(this, {{-1}})">
                      <div class="form-control-position">
                        <i class='bx bx-calendar'></i>
                      </div>
                      <small></small>
                    </fieldset>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitOutletForm({{-1}})" type="submit" class="btn btn-success mr-1">Add
                    Outlet</button>
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
<script src="{{asset('js/addEditOutlet.js')}}"></script>
<script src="{{asset('js/disableDates.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "name" + id:
        checkOutletName(element);
        break;
      case "route" + id:
        checkOutletRoute(element);
        break;
      case "address" + id:
        checkOutletAddress(element);
        break;
      case "contact" + id:
        checkOutletContact(element);
        break;
      case "date" + id:
        checkOutletDate(element);
        break;
    }
  }
</script>


@endsection