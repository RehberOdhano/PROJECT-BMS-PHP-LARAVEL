@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Packages')

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
          <li class="breadcrumb-item active" aria-current="page">Packages</li>
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
      <h2>Packages</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Package</span></button>
    </div>
  </div>
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header d-flex justify-content-between">
          <h2 class="card-title">Packages</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Package Name</th>
                  <th>Package Type</th>
                  <th>Package Size</th>
                  <th>Regular Discount</th>
                  <th>Added On</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($packages as $package)
                <tr>
                  <td>{{$package["pkg_name"]}}</td>
                  <td>{{$package["pkg_type"]}}</td>
                  <td>{{$package["size"]}}</td>
                  <td>{{$package["reg_discount"]}}%</td>
                  <td>{{date('d-m-Y', strtotime(substr($package["created_at"], 0, 10)))}}</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-package-<?php echo $package['id']; ?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $package['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>

                  {{-- Edit Package Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="edit-package-<?php echo $package['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Edit Package</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="pkgForm{{$package['id']}}" class="form"
                              action="{{URL('dists/admin/edit/package/'.$package['id'])}}" method="POST">
                              @csrf
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="pkgType{{$package['id']}}">Package Type</label>
                                      <input type="text" id="pkgType{{$package['id']}}" class="form-control"
                                        value="{{$package['pkg_type']}}" name="pkg_type" onkeyup="checkPkgType(this)"
                                        onfocusout="checkInputField(this, {{$package['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-10 col-10">
                                    <div class="form-group form-field">
                                      <label for="pkgSize{{$package['id']}}">Package Size</label>
                                      <?php $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$package['size'])?>
                                      <input type="text" id="pkgSize{{$package['id']}}" class="form-control"
                                        value="{{$arr[0]}}" name="pkg_size" onkeyup="checkPkgSize(this)"
                                        onfocusout="checkInputField(this, {{$package['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div style="margin-top: 22px;" class="col-md-2 col-2">
                                    <select name="units" id="units{{$package['id']}}" class="select2 form-control">
                                      <?php $arr = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$package['size'])?>
                                      @if($arr[1] == "ml" || $arr[1] == "ML")
                                      <option value="{{$arr[1]}}">{{$arr[1]}}</option>
                                      <option value="L">L</option>
                                      @else
                                      <option value="{{$arr[1]}}">{{$arr[1]}}</option>
                                      <option value="ML">ML</option>
                                      @endif
                                    </select>
                                    <small></small>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="pkg_name{{$package['id']}}">Package Name</label>
                                      <input type="text" id="pkgName{{$package['id']}}" class="form-control"
                                        value="{{$package['pkg_name']}}" name="pkg_name" onkeyup="checkPkgName(this)"
                                        onfocusout="checkInputField(this, {{$package['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="regDiscount{{$package['id']}}">Regular Discount</label>
                                      <input type="text" id="regDiscount{{$package['id']}}" class="form-control"
                                        value={{$package["reg_discount"]}} name="reg_discount"
                                        onkeyup="checkPkgDiscount(this)"
                                        onfocusout="checkInputField(this, {{$package['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-12 d-flex justify-content-end">
                                    <button onclick="submitPkgForm({{$package['id']}})" type="submit"
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

                  {{-- delete package modal --}}
                  <div class="modal fade text-left" id="delete-<?php echo $package['id']; ?>" tabindex="-1"
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
                          <form class="form" action="{{URL('dists/admin/delete/package/'.$package['id'])}}"
                            method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">If you delete this package, then the
                                      related products will also be deleted.
                                    </p>
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                    </p>
                                    <input name="package_delete" type="hidden" id="packagename" class="form-control"
                                      value="{{$package['id']}}">
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
                  <th>Package Name</th>
                  <th>Created On</th>
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

{{-- Add Package Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Package</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="pkgForm{{-1}}" class="form" action="/dists/admin/add/package" method="POST">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="pkgType{{-1}}">Package Type</label>
                    <input type="text" id="pkgType{{-1}}" class="form-control"
                      placeholder="Package Type: Bottle, Regular, Can, etc" name="pkg_type" onkeyup="checkPkgType(this)"
                      onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-10 col-10">
                  <div class="form-group form-field">
                    <label for="pkgSize{{-1}}">Package Size</label>
                    <input type="text" id="pkgSize{{-1}}" class="form-control"
                      placeholder="Package Size: 1.5L, 500ML, etc" name="package_size" onkeyup="checkPkgSize(this)"
                      onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div style="margin-top: 22px;" class="col-md-2 col-2">
                  <select style="width: 20px !important;" name="units" id="units{{-1}}" class="select2 form-control">
                    <option value="L">L</option>
                    <option value="ML">ML</option>
                  </select>
                  <small></small>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="pkgName{{-1}}">Package Name</label>
                    <input type="text" id="pkgName{{-1}}" class="form-control"
                      placeholder="Package Name: Coca Cola, Sprite, etc" name="pkgName" onkeyup="checkPkgName(this)"
                      onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="regDiscount{{-1}}">Regular Discount(%)</label>
                    <input type="text" id="regDiscount{{-1}}" class="form-control" placeholder="Regular Discount"
                      name="reg_discount" onkeyup="checkPkgDiscount(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitPkgForm({{-1}})" type="submit" class="btn btn-success mr-1">Add
                    Package</button>
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
<script src="{{asset('js/addEditPkg.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "pkgType" + id:
        checkPkgType(element);
        break;
      case "pkgSize" + id:
        checkPkgSize(element);
        break;
      case "pkgName" + id:
        checkPkgName(element);
        break;
      case "regDiscount" + id:
      checkPkgSize(element);
        break;
    }
  }
</script>


@endsection