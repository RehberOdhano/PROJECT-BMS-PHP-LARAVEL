@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Vehicles')

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
          <li class="breadcrumb-item active" aria-current="page">Vehicles</li>
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
  @elseif(session('warning'))
  <div class="alert alert-warning">
    {{Session::pull('warning')}}
  </div>
  @endif
</section>
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Vehicles</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Vehicle</span></button>
    </div>
  </div>
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header d-flex justify-content-between">
          <h2 class="card-title">Vehicles</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Vehicle Number</th>
                  <th>Make</th>
                  <th>Model</th>
                  <th>Fuel Type</th>
                  <th>Mileage</th>
                  <th>Engine Number</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($vehicles as $vehicle)
                <tr>
                  <td>{{$vehicle["number_plate"]}}</td>
                  <td>{{$vehicle["make"]}}</td>
                  <td>{{$vehicle["model"]}}</td>
                  <td>{{$vehicle["fuel_type"]}}</td>
                  <td>{{$vehicle["mileage"]}}</td>
                  <td>{{$vehicle["engine_num"]}}</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-flavor-<?php echo $vehicle['id']; ?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $vehicle['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>

                  {{-- Edit Vehicle Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="edit-flavor-<?php echo $vehicle['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Edit Vehicle</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="vehicleForm{{$vehicle['id']}}" method="POST"
                              action="{{URL('/dists/admin/vehicles/update/'.$vehicle['id'])}}">
                              @csrf
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-12 col-12">
                                    <label for="number_plate">Number Plate</label>
                                    <div class="form-group form-field">
                                      <input type="text" id="numPlate" class="form-control"
                                        value={{$vehicle["number_plate"]}} name="num_plate"
                                        onkeyup="checkVehicleNumPlate(this)" onfocusout="checkInputField(this)">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <label for="make">Make</label>
                                    <div class="form-group form-field">
                                      <input type="text" id="make{{$vehicle['id']}}" class="form-control"
                                        value={{$vehicle["make"]}} name="make">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <label for="model">Model</label>
                                    <div class="form-group form-field">
                                      <input type="text" id="model{{$vehicle['id']}}" class="form-control"
                                        value={{$vehicle["model"]}} name="model">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <label for="fuelType">Fuel Type</label>
                                    <div class="form-group form-field">
                                      <input type="text" id="fuelType{{$vehicle['id']}}" class="form-control"
                                        value={{$vehicle["fuel_type"]}} name="fuel_type">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <label for="mileage">Mileage</label>
                                    <div class="form-group form-field">
                                      <input type="text" id="mileage{{$vehicle['id']}}" class="form-control"
                                        value={{$vehicle["mileage"]}} name="mileage">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <label for="engine_num">Engine Number</label>
                                    <div class="form-group form-field">
                                      <input type="text" id="engine_num{{$vehicle['id']}}" class="form-control"
                                        value={{$vehicle["engine_num"]}} name="engine_num">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-12 d-flex justify-content-end">
                                    <button onclick="submitVehicleForm({{$vehicle['id']}});" type="submit"
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

                  {{-- delete vehicle modal --}}
                  <div class="modal fade text-left" id="delete-<?php echo $vehicle['id']; ?>" tabindex="-1"
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
                          <form class="form" action="{{URL('/dists/admin/vehicles/delete/'.$vehicle['id'])}}"
                            method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                    </p>
                                    <input name="delete_vehicle" type="hidden" id="delete_vehicle" class="form-control"
                                      value="{{$vehicle['id']}}">
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

{{-- Add Vehicle Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Vehicle</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="vehicleForm{{-1}}" class="form" method="POST" action="/dists/admin/vehicles/add">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-12 col-12">
                  <label for="numPlate">Number Plate</label>
                  <div class="form-group form-field">
                    <input type="text" id="numPlate{{-1}}" class="form-control" placeholder="Vehicle Number"
                      name="num_plate" onkeyup="checkVehicleNumPlate(this)" onfocusout="checkInputField(this)">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <label for="makeVehicle">Make</label>
                  <div class="form-group form-field">
                    <input type="text" id="makeVehicle" class="form-control" placeholder="Make" name="make">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <label for="modelVehicle">Model</label>
                  <div class="form-group form-field">
                    <input type="text" id="modelVehicle" class="form-control" placeholder="Model" name="model">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <label for="fuel_type">Fuel Type</label>
                  <div class="form-group form-field">
                    <input type="text" id="fuel_type" class="form-control" placeholder="Fuel Type" name="fuel_type">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <label for="mileageVehicle">Mileage</label>
                  <div class="form-group form-field">
                    <input type="text" id="mileageVehicle" class="form-control" placeholder="Mileage" name="mileage">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <label for="engine_number">Engine Number</label>
                  <div class="form-group form-field">
                    <input type="text" id="engine_number" class="form-control" placeholder="Engine Number"
                      name="engine_num">
                    <small></small>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitVehicleForm({{-1}})" type="submit" class="btn btn-success mr-1">Add</button>
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
<script src="{{asset('js/addEditVehicle.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element) => {
    if(element.id.includes('numPlate')) {
      checkVehicleNumPlate(element);
    }
  }
</script>


@endsection