@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Users')

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
          <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
      </nav>
    </div>
  </div>
  </div>
</section>
<section class="kb-search">
  @if(!session()->has('user'))
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Users</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add User</span></button>
    </div>
  </div>
  @endif
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
        <div class="card-header">
          <h2 class="card-title">Users</h2>
        </div>
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>Member Since</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{$user['name']}}</td>
                  <td>{{$user['email']}}</td>
                  <td>{{$user['phone_number']}}</td>
                  <td>{{$user['city']}}</td>
                  <td>{{date('d-m-Y', strtotime(substr($user["created_at"], 0, 10)))}}</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-Users-<?php echo $user['id']?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $user['id']?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>
                </tr>

                {{-- Edit Users Modal --}}
                <div class="modal-success mr-1 mb-1 d-inline-block">
                  <!--Success theme Modal -->
                  <div class="modal fade text-left" id="edit-Users-<?php echo $user['id']?>" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel110" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header bg-success">
                          <h5 class="modal-title white" id="myModalLabel110">Edit User</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form id="userForm{{$user['id']}}" class="form" method="POST"
                            action="{{URL('/dists/admin/users/edit/'.$user['id'])}}">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-6 col-12">
                                  <div class="form-group form-field">
                                    <label for="username{{$user['id']}}">Name</label>
                                    <input type="text" id="username{{$user['id']}}" value={{$user["name"]}}
                                      class="form-control" name="name" onkeyup="checkUserName(this)"
                                      onfocusout="checkInputField(this, {{$user['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group form-field">
                                    <label for="email{{$user['id']}}">Email</label>
                                    <input type="text" id="email{{$user['id']}}" class="form-control"
                                      value={{$user["email"]}} name="email" onkeyup="checkUserEmail(this)"
                                      onfocusout="checkInputField(this, {{$user['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group form-field">
                                    <label for="password{{$user['id']}}">Password</label>
                                    <input type="password" id="password{{$user['id']}}" class="form-control"
                                      placeholder="Password" name="password" onkeyup="checkUserPassword(this)"
                                      onfocusout="checkInputField(this, {{$user['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group form-field">
                                    <label for="confirmPass{{$user['id']}}">Confirm Password</label>
                                    <input type="password" id="confirmPass{{$user['id']}}" class="form-control"
                                      placeholder="Confirm Password" name="confirm_pass"
                                      onkeyup="checkConfirmPassword(this, {{$user['id']}})"
                                      onfocusout="checkInputField(this, {{$user['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group form-field">
                                    <label for="contact{{$user['id']}}">Phone Number</label>
                                    <input type="text" id="contact{{$user['id']}}" class="form-control"
                                      value={{$user["phone_number"]}} name="contact" onkeyup="checkUserContact(this)"
                                      onfocusout="checkInputField(this, {{$user['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group form-field">
                                    <label for="city{{$user['id']}}">City</label>
                                    <input type="text" id="city{{$user['id']}}" class="form-control"
                                      value="{{$user['city']}}" name="address" onkeyup="checkUserCity(this)"
                                      onfocusout="checkInputField(this, {{$user['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                  <button onclick="submitUserForm({{$user['id']}})" type="submit"
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

                {{-- delete user modal --}}
                <div class="modal fade text-left" id="delete-<?php echo $user['id']; ?>" tabindex="-1" role="dialog"
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
                        <form class="form" action="{{URL('dists/admin/users/delete/'.$user['id'])}}" method="POST">
                          @csrf
                          <div class="form-body">
                            <div class="row">
                              <div class="col-md-12 col-12">
                                <div class="form-label-group">
                                  <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                  </p>
                                  <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                    value="{{$user['id']}}">
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
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Add Users Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="userForm{{-1}}" class="form" method="POST" action="/dists/admin/users/add">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group form-field">
                    <label for="username{{-1}}">Name</label>
                    <input type="text" id="username{{-1}}" value="" class="form-control" placeholder="Full Name"
                      name="name" onkeyup="checkUserName(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group form-field">
                    <label for="email{{-1}}">Email</label>
                    <input type="text" id="email{{-1}}" value="" class="form-control" placeholder="Email" name="email"
                      onkeyup="checkUserEmail(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group form-field">
                    <label for="password{{-1}}">Password</label>
                    <input type="password" id="password{{-1}}" class="form-control" placeholder="Password"
                      name="password" onkeyup="checkUserPassword(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group form-field">
                    <label for="confirmPass{{-1}}">Confirm Password</label>
                    <input type="password" id="confirmPass{{-1}}" class="form-control" placeholder="Confirm Password"
                      name="confirm_pass" onkeyup="checkConfirmPassword(this, {{-1}})"
                      onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group form-field">
                    <label for="contact{{-1}}">Contact</label>
                    <input type="text" id="contact{{-1}}" value="" class="form-control" placeholder="Contact"
                      name="contact" onkeyup="checkUserContact(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group form-field">
                    <label for="city{{-1}}">City</label>
                    <input type="text" id="city{{-1}}" value="" class="form-control" placeholder="City" name="city"
                      onkeyup="checkUserCity(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitUserForm({{-1}})" type="submit" class="btn btn-success mr-1">Add User</button>
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
<script src="{{asset('/js/addEditUser.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "username" + id:
        checkUserName(element);
        break;
      case "email" + id:
        checkUserEmail(element);
        break;
      case "password" + id:
        checkUserPassword(element);
        break;
      case "confirmPass" + id:
        checkConfirmPassword(element,id);
        break;
      case "contact" + id:
        checkUserContact(element);
        break;
      case "city" + id:
        checkUserCity(element);
        break;
    }
  }
</script>

@endsection