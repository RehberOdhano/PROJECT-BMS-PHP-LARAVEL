@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Stocks')

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
          <li class="breadcrumb-item active" aria-current="page">Stocks</li>
        </ol>
      </nav>
    </div>
  </div>
  </div>
</section>
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Stocks</h2>
      <form method="GET" action="{{URL('/dists/admin/add/stock')}}">
        <button type="submit" class="btn btn-success glow mr-1 mb-1"><i class="bx bx-plus"></i>
          <span class="align-middle ml-25">Add Stock</span>
        </button>
      </form>
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
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header">
          <h2 class="card-title">Stocks</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">
            <table class="table zero-configuration">
              <thead>
                <tr>
                  <th>Delivery Date</th>
                  <th>Invoice No</th>
                  <th>Total Quantity</th>
                  <th>Total Amount</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @for($i = 0; $i < count($ids); $i++) <tr>
                  <td>{{date('d-m-Y', strtotime($dates[$i]))}}</td>
                  <td>{{$invoice_nums[$i]}}</td>
                  <td class="font-weight-bold">{{$totalQuantity[$i]}} Bottles</td>
                  <td class="text-success font-weight-bold">Rs.{{$totalAmount[$i]}}</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="/dists/admin/stock/print/details/{{$invoice_nums[$i]}}"><i
                            class="fa-solid fa-print" style="margin-right: 20px;"></i> print</a>
                        <a class="dropdown-item" href="/dists/admin/stock/details/{{$ids[$i]}}"><i
                            class="fa-solid fa-eye" style="margin-right: 20px;"></i> view</a>
                        <a class="dropdown-item" id="confirm-text" href="" data-target="#delete-<?php echo $ids[$i]; ?>"
                          data-toggle="modal"><i class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>
                  </tr>

                  {{-- delete stock modal --}}
                  <div class="modal fade text-left" id="delete-<?php echo $ids[$i]; ?>" tabindex="-1" role="dialog"
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
                          <form class="form" action="{{URL('dists/admin/delete/stock/'.$ids[$i])}}" method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                    </p>
                                    <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                      value="{{$ids[$i]}}">
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
                  @endfor
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Add Stock Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Stock</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="addStock" class="form" action="/dists/admin/add/stock" method="POST">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group form-field">
                    <label for="date">Delivery Date</label>
                    <fieldset class="form-group position-relative has-icon-left">
                      <input name="date" type="text" id="date" class="form-control pickadate-months-year"
                        placeholder="Delivery Date">
                      <div class="form-control-position">
                        <i class='bx bx-calendar'></i>
                      </div>
                      <small></small>
                    </fieldset>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group form-field">
                    <label class="text-bold-600" for="invoice_num">Invoice No.</label>
                    <input name="invoice_num" id="invoice_num" type="text" class="form-control @error('invoice_num') is-invalid 
                        @enderror" name="invoice_num" value="{{ old('invoice_num') }}" autocomplete="invoice_num"
                      placeholder="Invoice number">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group form-field">
                    <label class="text-bold-600" for="productCode">Product Code</label>
                    @if($products != null || !empty($products))
                    <select name="product_code" id="productCode" class="select2 form-control">
                      <option selected disabled>Code</option>
                      @foreach($products as $product)
                      <option value={{$product["product_code"]}}>{{$product["product_code"]}}</option>
                      @endforeach
                    </select>
                    <small></small>
                    @else
                    <select id="productCode" class="select2 form-control">
                      <option selected disabled>--PRODUCT CODE--</option>
                      <option value="NO OUTLETS">"NO PRODUCT CODES"</option>
                    </select>
                    @endif
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group form-field">
                    <label for="stkquantity">Quantity</label>
                    <input type="text" id="stkquantity" value="" class="form-control" placeholder="Quantity"
                      name="quantity">
                    <small></small>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button type="submit" class="btn btn-success mr-1">Add Stock</button>
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
{{-- <script src="{{asset('js/editStock.js')}}"></script> --}}
<script>
  $('div.alert').delay(3000).slideUp(300);
</script>
@endsection