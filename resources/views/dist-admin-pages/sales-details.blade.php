@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title', 'Sales Details')

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
                    <li class="breadcrumb-item active" aria-current="page">Sales Details</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<section class="kb-search">
    <div class="row">
        <div class="col d-flex justify-content-between">
            <h2>Sales Details</h2>
        </div>
    </div>
</section>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($sales == null)
                <h3>Nothing to display</h3>
                @else
                {{-- <div class="row">
                    <div class="col-md-6 col-6">
                        <label style="margin-left: 30px; margin-top: 20px; font-weight: bold" for="date">Delivery
                            Date</label>
                        <p style="margin-left: 30px;">{{ $sales["0"]->delivery_date }}</p>
                    </div>
                    <div class="col-md-6 col-6 d-flex" style="align-items: center">
                        <div>
                            <label style="margin-left: 320px; margin-top: 20px; font-weight: bold"
                                for="invoice_num">Invoice Number</label>
                            <p style="margin-left: 320px;">{{ $stocks["0"]->invoice_number }}</p>
                        </div>
                        <a style="margin-left: 20px;" href="/dists/admin/stock/print/details/{{$stocks["
                            0"]->invoice_number}}">
                            <i class="fa-solid fa-print"></i>
                        </a>
                    </div>
                </div> --}}
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="flex:1;">Product Code</th>
                                    <th style="flex:1;">Product Name</th>
                                    <th style="flex:1;">Package Size</th>
                                    <th style="flex:1;">Package Type</th>
                                    <th style="flex:1;">Original Price</th>
                                    <th style="flex:1;">New Price</th>
                                    <th style="flex:1;">Quantity</th>
                                    <th style="flex:1;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->product_code }}</td>
                                    <td>{{ $sale->product_name }}</td>
                                    <td>{{ $sale->package_size }}</td>
                                    <td>{{ $sale->pkg_type }}</td>
                                    <td>Rs.{{ $sale->original_price }}</td>
                                    <td>Rs.{{ $sale->new_price }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>Rs.{{ $sale->amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--
                    <hr class="mt-3">
                    <div class="row mt-2 justify-content-center">
                        <div class="text-align:left;float:left; d-flex ml-4">
                            <h5 style="font-weight: bold; font-size: 22px;">Grand Total:</h5>
                            <span class="ml-1 text-success"
                                style="font-weight: bold; font-size: 22px;">Rs.{{$total}}/-</span>
                        </div>
                    </div> --}}
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