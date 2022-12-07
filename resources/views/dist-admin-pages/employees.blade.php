@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Employees')

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
          <li class="breadcrumb-item active" aria-current="page">Employees</li>
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
      <h2>Employees</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Employee</span></button>
    </div>
  </div>
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header">
          <h2 class="card-title">Employees</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Designation</th>
                  <th>Department</th>
                  <th>Contact</th>
                  <th>Employee Since</th>
                  <th>Salary</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($employees as $employee)
                <tr>
                  <td>{{$employee["name"]}}</td>
                  <td>{{$employee["designation"]}}</td>
                  <td>{{$employee["department"]}}</td>
                  <td>{{$employee["contact"]}}</td>
                  <td>{{date('d-m-Y', strtotime($employee["employee_since"]))}}</td>
                  <td>Rs.{{$employee["salary"]}}</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-Employees-<?php echo $employee['id']; ?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $employee['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>
                </tr>

                {{-- Edit Employees Modal --}}
                <div class="modal-success mr-1 mb-1 d-inline-block">
                  <!--Success theme Modal -->
                  <div class="modal fade text-left" id="edit-Employees-<?php echo $employee['id']; ?>" tabindex="-1"
                    role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header bg-success">
                          <h5 class="modal-title white" id="myModalLabel110">Edit Employee</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form id="employeeForm{{$employee['id']}}" class="form" method="POST"
                            action="{{URL('dists/admin/edit/employee/'.$employee['id'])}}">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="name{{$employee['id']}}">Name</label>
                                    <input type="text" id="name{{$employee['id']}}" class="form-control"
                                      value='{{$employee["name"]}}' name="name" onkeyup="checkEmployeeName(this)"
                                      onfocusout="checkInputField(this, {{$employee['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="designation{{$employee['id']}}">Designation</label>
                                    <select name="designation" id="designation{{$employee['id']}}"
                                      class="select2 form-control" onchange="checkEmployeeDesignation(this)"
                                      onfocusout="checkInputField(this, {{$employee['id']}})">
                                      {{-- <option selected disabled value="">Designation</option> --}}
                                      @if($employee['designation'] == "Manager")
                                      <option selected value={{$employee['designation']}}>{{$employee['designation']}}
                                      </option>
                                      <option value="Salesman">Salesman</option>
                                      <option value="Driver">Driver</option>
                                      @elseif($employee['designation'] == "Salesman")
                                      <option selected value={{$employee['designation']}}>{{$employee['designation']}}
                                      </option>
                                      <option value="Manager">Manager</option>
                                      <option value="Driver">Driver</option>
                                      @elseif($employee['designation'] == "Driver")
                                      <option selected value={{$employee['designation']}}>{{$employee['designation']}}
                                      </option>
                                      <option value="Manager">Manager</option>
                                      <option value="Salesman">Salesman</option>
                                      @endif
                                    </select>
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="dept{{$employee['id']}}">Department</label>
                                    <select name="dept" id="dept{{$employee['id']}}" class="select2 form-control"
                                      onchange="checkEmployeeDept(this)"
                                      onfocusout="checkInputField(this, {{$employee['id']}})">
                                      @if($employee['department'] == "DeptA")
                                      <option selected value={{$employee["department"]}}>{{$employee["department"]}}
                                      </option>
                                      <option value="DeptB">DeptB</option>
                                      <option value="DeptC">DeptC</option>
                                      @elseif($employee['department'] == "DeptB")
                                      <option selected value={{$employee["department"]}}>{{$employee["department"]}}
                                      </option>
                                      <option value="DeptA">DeptA</option>
                                      <option value="DeptC">DeptC</option>
                                      @elseif($employee['department'] == "DeptC")
                                      <option selected value={{$employee["department"]}}>{{$employee["department"]}}
                                      </option>
                                      <option value="DeptA">DeptA</option>
                                      <option value="DeptB">DeptB</option>
                                      @endif
                                    </select>
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="contact{{$employee['id']}}">Contact</label>
                                    <input type="text" id="contact{{$employee['id']}}" class="form-control"
                                      value={{$employee["contact"]}} name="contact" onkeyup="checkEmployeeContact(this)"
                                      onfocusout="checkInputField(this, {{$employee['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="salary{{$employee['id']}}">Salary</label>
                                    <input type="text" id="salary{{$employee['id']}}" class="form-control"
                                      value={{$employee["salary"]}} name="salary" onkeyup="checkEmployeeSalary(this)"
                                      onfocusout="checkInputField(this, {{$employee['id']}})">
                                    <small></small>
                                  </div>
                                </div>
                                <div class="col-md-12 col-12">
                                  <div class="form-group form-field">
                                    <label for="date{{$employee['id']}}">Employee Since</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                      <input name="date" type="date" id="date{{$employee['id']}}"
                                        class="form-control date_picker" value="{{$employee['employee_since']}}"
                                        onchange="checkDate(this)" onclick="checkDate(this)"
                                        onfocusout="checkInputField(this, {{$employee['id']}})">
                                      <div class="form-control-position">
                                        <i class='bx bx-calendar'></i>
                                      </div>
                                      <small></small>
                                    </fieldset>
                                  </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                  <button onclick="submitEmployeeForm({{$employee['id']}})" type="submit"
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
                <div class="modal fade text-left" id="delete-<?php echo $employee['id']; ?>" tabindex="-1" role="dialog"
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
                        <form class="form" action="{{URL('dists/admin/delete/employee/'.$employee['id'])}}"
                          method="POST">
                          @csrf
                          <div class="form-body">
                            <div class="row">
                              <div class="col-md-12 col-12">
                                <div class="form-label-group">
                                  <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                  </p>
                                  <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                    value="{{$employee['id']}}">
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
                {{--
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>Employee Since</th>
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

{{-- Add Employees Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Employee</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="employeeForm{{-1}}" class="form" method="POST" action="/dists/admin/add/employee">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="name{{-1}}">Name</label>
                    <input type="text" id="name{{-1}}" value="" class="form-control" placeholder="Employee Name"
                      name="name" onkeyup="checkEmployeeName(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="designation{{-1}}">Designation</label>
                    <select name="designation" id="designation{{-1}}" class="select2 form-control"
                      onchange="checkEmployeeDesignation(this)" onfocusout="checkInputField(this, {{-1}})">
                      <option selected disabled value="">Designation</option>
                      <option value="Manager">Manager</option>
                      <option value="Salesman">Salesman</option>
                      <option value="Driver">Driver</option>
                    </select>
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="dept{{-1}}">Department</label>
                    <select name="dept" id="dept{{-1}}" class="select2 form-control" onchange="checkEmployeeDept(this)"
                      onfocusout="checkInputField(this, {{-1}})">
                      <option selected disabled value="">Department</option>
                      <option value="DeptA">DeptA</option>
                      <option value="DeptB">DeptB</option>
                      <option value="DeptC">DeptC</option>
                    </select>
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="contact{{-1}}">Contact</label>
                    <input type="text" id="contact{{-1}}" value="" class="form-control" placeholder="Contact"
                      name="contact" onkeyup="checkEmployeeContact(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="salary{{-1}}">Salary</label>
                    <input type="text" id="salary{{-1}}" value="" class="form-control" placeholder="Salary"
                      name="salary" onkeyup="checkEmployeeSalary(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="date{{-1}}">Employee Since</label>
                    <fieldset class="form-group position-relative has-icon-left">
                      <input name="date" type="date" id="date{{-1}}" value="" class="form-control date_picker"
                        placeholder="Membership Date" onchange="checkDate(this)" onclick="checkDate(this)"
                        onfocusout="checkInputField(this, {{-1}})">
                      <div class="form-control-position">
                        <i class='bx bx-calendar'></i>
                      </div>
                      <small></small>
                    </fieldset>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitEmployeeForm({{-1}})" type="submit" class="btn btn-success mr-1">Add
                    Employee</button>
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
<script src="{{asset('/js/addEditEmp.js')}}"></script>
<script src="{{asset('/js/disableDates.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "name" + id:
        checkEmployeeName(element);
        break;
      case "dept" + id:
        checkEmployeeDept(element);
        break;
      case "designation" + id:
        checkEmployeeDesignation(element);
        break;
      case "contact" + id:
        checkEmployeeContact(element);
        break;
      case "salary" + id:
        checkEmployeeSalary(element);
        break;
      case "date" + id:
        checkDate(element);
        break;
    }
  }
</script>
@endsection