@extends('layouts.super-admin.contentLayoutMaster')
{{-- title --}}
@section('title','Admins')

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
          <li class="breadcrumb-item active" aria-current="page">Admins</li>
        </ol>
      </nav>
    </div>
  </div>
  </div>
</section>
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Admins</h2>
      {{-- <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Users</span></button> --}}
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
  @elseif(session('warning'))
  <div class="alert alert-warning">
    {{Session::pull('warning')}}
  </div>
  @endif
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header">
          <h2 class="card-title">Users</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  {{-- <th>Distribution Name
                  <th> --}}
                  <th>Name</th>
                  <th>Distribution Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($admins as $admin)
                <tr>
                  <td>{{$admin["name"]}}</td>
                  <td>{{$admin["dist"]->name}}</td>
                  <td>{{$admin["email"]}}</td>
                  <td>{{$admin["phone_number"]}}</td>
                  <td>{{$admin["city"]}}</td>
                  @if($admin["status"] == "BLOCKED")
                  <td class="text-danger font-weight-bold text-uppercase text-left-align">
                    {{$admin["status"]}}
                  </td>
                  @else
                  <td class="text-success font-weight-bold text-uppercase text-left-align">
                    Active
                  </td>
                  @endif
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-Users-<?php echo $admin['id']; ?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $admin['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>

                  {{-- Edit Admins Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="edit-Users-<?php echo $admin['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Edit Admin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="distAdminForm{{$admin['id']}}" class="form" method="POST"
                              action="{{URL('/superadmin/admin/edit/'.$admin['id'])}}">
                              @csrf
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="adminname">Name</label>
                                      <input type="text" onfocusout="checkInputField(this, {{$admin['id']}})"
                                        id="name{{$admin['id']}}" value="{{$admin['name']}}" class="form-control"
                                        name="name" onkeyup="checkDistAdminName(this)">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="adminemail">Email</label>
                                      <input type="text" onfocusout="checkInputField(this, {{$admin['id']}})"
                                        id="email{{$admin['id']}}" value={{$admin["email"]}} class="form-control"
                                        name="email" onkeyup="checkDistAdminEmail(this)">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="password{{$admin['id']}}">Password</label>
                                      <input type="password" onfocusout="checkInputField(this, {{$admin['id']}})"
                                        id="password{{$admin['id']}}" value="" class="form-control"
                                        placeholder="Password" name="password" onkeyup="checkDistAdminPassword(this)">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="confirm_pass{{$admin['id']}}">Confirm Password</label>
                                      <input type="password" onfocusout="checkInputField(this, {{$admin['id']}})"
                                        id="confirm_pass{{$admin['id']}}" value="" class="form-control"
                                        placeholder="Confirm Password" name="confirm_pass"
                                        onkeyup="checkConfirmPassword(this, {{$admin['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="admincontact">Contact</label>
                                      <input type="text" onfocusout="checkInputField(this, {{$admin['id']}})"
                                        id="contact{{$admin['id']}}" value={{$admin["phone_number"]}}
                                        class="form-control" name="contact" onkeyup="checkDistAdminContact(this)">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="admincity">Address</label>
                                      <input type="text" onfocusout="checkInputField(this, {{$admin['id']}})"
                                        id="city{{$admin['id']}}" value="{{$admin['city']}}" class="form-control"
                                        name="city" onkeyup="checkDistAdminCity(this)">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success mr-1">Update</button>
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

                  {{-- Delete Admin Modal --}}
                  <div class="modal fade text-left" id="delete-<?php echo $admin['id']; ?>" tabindex="-1" role="dialog"
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
                          <form class="form" action="{{URL('superadmin/admin/delete/'.$admin['id'])}}" method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                    </p>
                                    <input name="delete_admin" type="hidden" id="delete_admin" class="form-control"
                                      value="{{$admin['id']}}">
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
                  <th>Member Since</th>
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

@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script src="{{asset('js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/forms/number-input.js')}}"></script>
<script src="{{asset('js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>
<script src="{{asset('js/scripts/extensions/sweet-alerts.js')}}"></script>
<script src="{{asset('js/addDistAdmin.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "name" + id:
        checkDistAdminName(element);
        break;
      case "email" + id:
        checkDistAdminEmail(element);
        break;
      case "password" + id:
        checkDistAdminPassword(element);
        break;
      case "confirm_pass" + id:
        checkConfirmPassword(element,id);
        break;
      case "contact" + id:
        checkDistAdminContact(element);
        break;
      case "city" + id:
        checkDistAdminCity(element);
        break;
    }
  }
</script>


@endsection