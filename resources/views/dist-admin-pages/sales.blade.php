@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Sales')

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
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
@endsection

@section('content')
<!-- Knowledge base Jumbotron start -->
<section id="breadcrumb-rounded-divider" class="mb-2">
  <div class="row">
    <div class="col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded-pill breadcrumb-divider">
          <li class="breadcrumb-item"><a href="/dists/admin/dashboard"><i class="bx bx-home"></i></a></li>
          <li class="breadcrumb-item active" aria-current="page">Sales</li>
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
  @elseif(session('not in stock'))
  <div class="alert alert-danger">
    {{Session::pull('not in stock')}}
  </div>
  @endif
</section>
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Sales</h2>
      <form method="GET" action="{{URL('/dists/admin/add/sale')}}">
        <button type="submit" class="btn btn-success glow mr-1 mb-1"><i class="bx bx-plus"></i>
          <span class="align-middle ml-25">Add Sales</span>
        </button>
      </form>
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
                  <th>Outlet</th>
                  <th>Salesman</th>
                  <th>Vehicle Number</th>
                  <th>Driver Name</th>
                  <th>Route</th>
                  <th>Total Amount</th>
                  <th>Amount Received</th>
                  <th>Due Amount</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($sales as $sale)
                <tr>
                  <td>{{date('d-m-Y', strtotime(substr($sale["created_at"], 0, 10)))}}</td>
                  <td>{{$sale["outlet"]}}</td>
                  <td>{{$sale["salesman"]}}</td>
                  <td>{{$sale["vehicle_number"]}}</td>
                  <td>{{$sale["driver_name"]}}</td>
                  <td>{{$sale["route"]}}</td>
                  <td class="text-success font-weight-bold text-center">Rs.{{$sale["total_amount"]}}</td>
                  <td class="text-success font-weight-bold text-center">Rs.{{$sale["amount_received"]}}</td>
                  <td class="text-danger font-weight-bold text-center">Rs.{{$sale["due_amount"]}}</td>

                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/dists/admin/sales/details/{{$sale['id']}}"><i
                            class="fa-solid fa-eye" style="margin-right: 20px;"></i> view</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $sale['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>
                </tr>

                {{-- Edit Sale Modal --}}
                {{-- <div class="modal-success mr-1 mb-1 d-inline-block">
                  <!--Success theme Modal -->
                  <div class="modal fade text-left" id="edit-sale-<?php echo $sale['id']?>" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel110" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header bg-success">
                          <h5 class="modal-title white" id="myModalLabel110">Edit Sale</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form class="form" method="POST" action="{{URL('/dists/admin/edit/sale/'.$sale['id'])}}">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-6 col-12">
                                  <div class="form-group">
                                    <label for="outlet-search">Choose Outlet</label>
                                    @if($outlets != null || !empty($outlets))
                                    <select id="outlet-search" class="select2 form-control">
                                      <option selected disabled>Outlet</option>
                                      @foreach($outlets as $outlet)
                                      <option value={{$outlet["name"]}}>{{$outlet["name"]}}</option>
                                      @endforeach
                                    </select>
                                    @else
                                    <select id="outlet-search" class="select2 form-control">
                                      <option selected disabled>Outlet</option>
                                      <option value="NO OUTLETS">"NO OUTLETS"</option>
                                    </select>
                                    @endif
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group">
                                    <label for="route">Route</label>
                                    @if ($outlets != null || !empty($outlets))
                                    <select id="route-search" class="select2 form-control">
                                      <option selected disabled>--Choose Route--</option>
                                      @foreach ($outlets as $outlet)
                                      <option value={{ $outlet['route'] }}>{{ $outlet['route'] }}</option>
                                      @endforeach
                                    </select>
                                    @else
                                    <select id="route-search" class="select2 form-control">
                                      <option selected disabled>--Choose Route--</option>
                                      <option value="NO OUTLETS">"NO ROUTES"</option>
                                    </select>
                                    @endif
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group">
                                    <label for="vehicle">Vehicle</label>
                                    @if ($vehicles != null || !empty($vehicles))
                                    <select id="vehicle-search" class="select2 form-control">
                                      <option selected disabled>--Choose Vehicle--</option>
                                      @foreach ($vehicles as $vehicle)
                                      <option value={{ $vehicle['vehicle_number'] }}>{{ $vehicle['vehicle_number'] }}
                                      </option>
                                      @endforeach
                                    </select>
                                    @else
                                    <select id="vehicle-search" class="select2 form-control">
                                      <option selected disabled>--Choose Vehicle--</option>
                                      <option value="NO OUTLETS">"NO VEHICLES"</option>
                                    </select>
                                    @endif
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group">
                                    <label for="sales_man">Salesman</label>
                                    @if ($salesmans != null || !empty($salesmans))
                                    <select id="salesman_search" class="select2 form-control">
                                      <option selected disabled>--Choose Salesman--</option>
                                      @foreach ($salesmans as $salesman)
                                      <option value={{ $salesman['name'] }}>{{ $salesman['name'] }}</option>
                                      @endforeach
                                    </select>
                                    @else
                                    <select id="salesman_search" class="select2 form-control">
                                      <option selected disabled>--Choose Salesman--</option>
                                      <option value="NO OUTLETS">"NO SALESMAN"</option>
                                    </select>
                                    @endif
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group">
                                    <label for="drivers">Driver</label>
                                    @if ($drivers != null || !empty($drivers))
                                    <select id="drivers-search" class="select2 form-control">
                                      <option selected disabled>--Choose Driver--</option>
                                      @foreach ($drivers as $driver)
                                      <option value={{ $driver['name'] }}>{{ $driver['name'] }}</option>
                                      @endforeach
                                    </select>
                                    @else
                                    <select id="drivers-search" class="select2 form-control">
                                      <option selected disabled>--Choose Salesman--</option>
                                      <option value="NO OUTLETS">"NO DRIVERS"</option>
                                    </select>
                                    @endif
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group">
                                    <label for="productCode">Product Code</label>
                                    <input type="text" id="productCode" placeholder="Product Code"
                                      data-bts-button-down-class="btn btn-light-secondary"
                                      data-bts-button-up-class="btn btn-light-secondary" />
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="text" id="quantity" class="touchspin-color" placeholder="Quantity"
                                      data-bts-button-down-class="btn btn-light-secondary"
                                      data-bts-button-up-class="btn btn-light-secondary" />
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group">
                                    <label for="soldon">Order Date</label>
                                    <fieldset class="form-group position-relative has-icon-left">
                                      <input type="text" id="soldon" class="form-control pickadate-months-year"
                                        placeholder="Sold on">
                                      <div class="form-control-position">
                                        <i class='bx bx-calendar'></i>
                                      </div>
                                    </fieldset>
                                  </div>
                                </div>
                                <div class="col-md-6 col-12">
                                  <div class="form-group">
                                    <label for="sale-price">Sale Price</label>
                                    <input type="text" id="sale-price" class="touchspin-color" placeholder="Sale Price"
                                      data-bts-button-down-class="btn btn-light-secondary"
                                      data-bts-button-up-class="btn btn-light-secondary" />
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
                </div> --}}

                {{-- DELETE MODAL --}}
                <div class="modal fade text-left" id="delete-<?php echo $sale['id']; ?>" tabindex="-1" role="dialog"
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
                        <form class="form" action="{{URL('dists/admin/delete/sale/'.$sale['id'])}}" method="POST">
                          @csrf
                          <div class="form-body">
                            <div class="row">
                              <div class="col-md-12 col-12">
                                <div class="form-label-group">
                                  <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                  </p>
                                  <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                    value="{{$sale['id']}}">
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
          {{--
          <hr class=""> --}}
          <div class="row mt-2 justify-content-center">
            <div class="text-align:left;float:left; d-flex ml-4">
              <h5 style="font-weight: bold; font-size: 22px;">Total Amount:</h5>
              <span class="ml-1 text-success" style="font-weight: bold; font-size: 22px;">Rs.{{$totalSale}}/-</span>
            </div>
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
<script>
  $('div.alert').delay(3000).slideUp(300);
</script>


@endsection