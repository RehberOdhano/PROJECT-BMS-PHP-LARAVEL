@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title', 'Stock Details')

{{-- page-styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/animate/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/pickers/pickadate/pickadate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/pickers/daterange/daterangepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/login.css') }}">
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
                    <li class="breadcrumb-item active" aria-current="page">Stock Details</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<section class="kb-search">
    <div class="row">
        <div class="col d-flex justify-content-between">
            <h2>Stock Details</h2>
        </div>
    </div>
</section>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($stocks == null)
                <h3>Nothing to display</h3>
                @else
                <div class="row">
                    <div class="col-md-6 col-6">
                        <label style="margin-left: 30px; margin-top: 20px; font-weight: bold" for="date">Delivery
                            Date</label>
                        <p style="margin-left: 30px;">{{date('d-m-Y', strtotime(substr($stocks["0"]->delivery_date, 0, 10)))}}</p>
                    </div>
                    <div class="col-md-6 col-6 d-flex" style="align-items: center">
                        <div>
                            <label style="margin-left: 320px; margin-top: 20px; font-weight: bold"
                                for="invoice_num">Invoice Number</label>
                            <p style="margin-left: 320px;">{{ $stocks["0"]->invoice_number }}</p>
                        </div>
                        <a href="/dists/admin/stock/print/details/{{$stocks['0']->invoice_number}}" style="margin-left:
                            20px;">
                            <i class="fa-solid fa-print"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="flex:1;">Product Code</th>
                                    <th style="flex:1;">Product Name</th>
                                    <th style="flex:1;">Package Size</th>
                                    <th style="flex:1;">Package Type</th>
                                    <th style="flex:1;">Unit Price</th>
                                    <th style="flex:1;">Quantity</th>
                                    <th style="flex:1;">Regular Discount</th>
                                    <th style="flex:1;">Advance Income Tax</th>
                                    <th style="flex:1;">Total Amount</th>
                                    {{-- <th style="flex:1;">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @for($i = 0; $i < count($productCodes); $i++) 
                                <tr>
                                    <td>{{ $productCodes[$i] }}</td>
                                    <td>{{ $productNames[$i] }}</td>
                                    <td>{{ $pkgSizes[$i] }}</td>
                                    <td>{{ $pkgTypes[$i] }}</td>
                                    <td>Rs.{{ $unitPrices[$i] }}</td>
                                    @if($Quantities[$i] == 0)
                                        <td class="text-danger font-weight-bold">NOT IN STOCK</td>
                                    @else
                                        <td>{{ $Quantities[$i] }}</td>
                                    @endif
                                    <td>{{ $regDiscounts[$i] }}%</td>
                                    <td>{{ $advIncomeTaxes[$i] }}%</td>
                                    @if($Quantities[$i] == 0)
                                        <td>NIL</td>
                                    @else
                                        <td>Rs.{{ $totalAmounts[$i] }}</td>
                                    @endif
                                    {{-- <td class="text-center py-1">
                                        <div class="dropup">
                                            <span
                                                class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                role="menu">
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if($Quantities[$i] == 0)
                                                    <a class="dropdown-item" data-target="#edit-stock-<?php echo $stocks['0']->id; ?>" data-toggle="modal" 
                                                        href="/dists/admin/edit/stock/{{$stocks['0']->id}}/{{$productCodes[$i]}}">
                                                        <i class="bx bx-edit-alt mr-1" style="margin-right: 20px;"></i>edit
                                                    </a>
                                                @else
                                                    <a style="pointer-events: none" class="dropdown-item" data-target="#edit-stock-<?php echo $stocks['0']->id; ?>" data-toggle="modal" 
                                                        href="/dists/admin/edit/stock/{{$stocks['0']->id}}/{{$productCodes[$i]}}">
                                                        <i class="bx bx-edit-alt mr-1" style="margin-right: 20px;"></i>edit
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td> --}}
                                </tr>

                                {{-- Edit Stock Modal --}}
                                <div class="modal-success mr-1 mb-1 d-inline-block">
                                    <div class="modal fade text-left" id="edit-stock-<?php echo $stocks['0']->id; ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success">
                                                    <h5 class="modal-title white" id="myModalLabel110">Update Stock</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editStockForm{{$stocks['0']->id}}" class="form" method="POST"
                                                        action="{{URL('dists/admin/edit/stock/'.$stocks['0']->id.'/'.$productCodes[$i])}}">
                                                        @csrf
                                                        <div class="form-body">
                                                            <div class="row">
                                                                {{-- <div class="col-md-12 col-12">
                                                                    <div class="form-group form-field">
                                                                    <label for="editProductCode{{$productCodes[$i]}}">Product Code</label>
                                                                    <input disabled type="text" id="editProductCode{{$productCodes[$i]}}" class="form-control"
                                                                        value={{$productCodes[$i]}} name="editProductCode" style="border: 1px solid">
                                                                    <small></small>
                                                                    </div>
                                                                </div> --}}
                                                                <input type="hidden" value={{$productCodes[$i]}} name="productCode">
                                                                <div class="col-md-12 col-12">
                                                                    <div class="form-group form-field">
                                                                    <label for="editStock{{$stocks['0']->id}}">Quantity</label>
                                                                    <input type="text" id="editStock{{$stocks['0']->id}}" class="form-control" value='' name="editStock">
                                                                    <small></small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 d-flex justify-content-end">
                                                                    <button type="submit" class="btn btn-success mr-1">Update Stock</button>
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
                            @endfor
                        </tbody>
                    </table>
                </div>
                <hr class="mt-3">
                <div class="row mt-2 justify-content-center">
                    <div class="text-align:left;float:left; d-flex ml-4">
                        <h5 style="font-weight: bold; font-size: 22px;">Grand Total:</h5>
                        <span class="ml-1 text-success" style="font-weight: bold; font-size: 22px;">Rs.{{$total}}/-</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</section>
@endsection

{{-- page scripts --}}
@section('vendor-scripts')
<script src="{{ asset('vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/moment.min.js') }}"></script>
<script src="{{ asset('vendors/js/pickers/daterange/daterangepicker.js') }}"></script>
@endsection

{{-- page scripts --}}
@section('page-scripts')
<script src="{{ asset('js/scripts/datatables/datatable.js') }}"></script>
<script src="{{ asset('js/scripts/forms/select/form-select2.js') }}"></script>
<script src="{{ asset('js/scripts/forms/number-input.js') }}"></script>
<script src="{{ asset('js/scripts/pickers/dateTime/pick-a-datetime.js') }}"></script>
<script src="{{ asset('js/scripts/extensions/sweet-alerts.js') }}"></script>
<script src="{{ asset('js/editStock.js') }}"></script>
<script>
    $('div.alert').delay(3000).slideUp(300);
</script>
@endsection