@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title', 'Add Sale')

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
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/login.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<!-- Knowledge base Jumbotron start -->
<section id="breadcrumb-rounded-divider" class="mb-2">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb rounded-pill breadcrumb-divider">
                    <li class="breadcrumb-item"><a href="/dists/admin/dashboard"><i class="bx bx-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Sales</li>
                </ol>
            </nav>
        </div>
    </div>
    </div>
</section>

{{-- Add Sales Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block" style="margin-left: -35px">
    <!--Success theme Modal -->
    <div class="modal-success mr-1 mb-1 d-inline-block">
        <div class="modal-body">
            <form id="addSaleForm" class="form" method="POST" enctype="multipart/form-data"
                action="/dists/admin/addSale">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="outlet">Outlet</label>
                                @if ($outlets != null || !empty($outlets))
                                <select id="outlet-search" class="select2 form-control"
                                    onchange="getOutletRoutes(this.value); checkOutetValue(this)">
                                    <option selected disabled>Choose Outlet</option>
                                    @foreach ($outlets as $outlet)
                                    <option value={{ $outlet['name'] }}>{{ $outlet['name'] }}</option>
                                    @endforeach
                                </select>
                                @else
                                <select id="outlet-search" class="select2 form-control">
                                    <option selected disabled>Choose Outlet</option>
                                    <option value="NO OUTLETS">"NO OUTLETS"</option>
                                </select>
                                @endif
                                <small></small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="route-search">Route</label>
                                <input name="route" style="border: 1px solid" disabled class="form-control" type="text"
                                    id="route-search" value="Route" onchange="checkRouteValue(this)">
                                <small></small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="vehicle">Vehicle</label>
                                @if ($vehicles != null || !empty($vehicles))
                                <select onchange="checkVehicleValue(this)" id="vehicle-search"
                                    class="select2 form-control">
                                    <option selected disabled>Choose Vehicle</option>
                                    @foreach ($vehicles as $vehicle)
                                    <option value={{ $vehicle['number_plate'] }}>{{ $vehicle['number_plate'] }}</option>
                                    @endforeach
                                </select>
                                <small></small>
                                @else
                                <select id="vehicle-search" class="select2 form-control">
                                    <option selected disabled>Choose Vehicle</option>
                                    <option value="NO OUTLETS">"NO VEHICLES"</option>
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="sales_man">Salesman</label>
                                @if ($salesmans != null || !empty($salesmans))
                                <select onchange="checkSalesmanValue(this)" id="salesman_search"
                                    class="select2 form-control">
                                    <option selected disabled>Choose Salesman</option>
                                    @foreach ($salesmans as $salesman)
                                    <option value={{ $salesman['name'] }}>{{ $salesman['name'] }}</option>
                                    @endforeach
                                </select>
                                <small></small>
                                @else
                                <select id="salesman_search" class="select2 form-control">
                                    <option selected disabled>Choose Salesman</option>
                                    <option value="NO OUTLETS">"NO SALESMAN"</option>
                                </select>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="drivers">Driver</label>
                                @if ($drivers != null || !empty($drivers))
                                <select onchange="checkDriverValue(this)" id="drivers-search"
                                    class="select2 form-control">
                                    <option selected disabled>Choose Driver</option>
                                    @foreach ($drivers as $driver)
                                    <option value={{ $driver['name'] }}>{{ $driver['name'] }}</option>
                                    @endforeach
                                </select>
                                <small></small>
                                @else
                                <select id="drivers-search" class="select2 form-control">
                                    <option selected disabled>Choose Driver</option>
                                    <option value="NO OUTLETS">"NO DRIVERS"</option>
                                </select>
                                @endif
                            </div>
                        </div>
                        <div style="margin-top: 20px;">
                            <table style="paddding:15px;" id="data_table" class="table table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th style="width:120px; padding: 10px;" scope="col">Product Code</th>
                                        <th style="width:120px; padding: 10px;" scope="col">Product Name</th>
                                        <th style="width:120px; padding: 10px;" scope="col">Size</th>
                                        <th style="width:120px; padding: 10px;" scope="col">Type</th>
                                        <th style="width:120px; padding: 10px;" scope="col">Original Price</th>
                                        <th style="width:120px; padding: 10px;" scope="col">New Price</th>
                                        <th style="width:120px; padding: 10px;" scope="col">Quantity</th>
                                        <th style="width:120px; padding: 10px;" scope="col">Amount</th>
                                        <th style="width:120px; padding: 10px;" scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="body">
                                    <tr id="row1">
                                        <td id="code_opt" class="text-right" style="column-width: 100px;">
                                            @if($products != null || !empty($products))
                                            <select name="product_code" id="productCode1" class="select2 form-control"
                                                onchange="getState(this.value, 1)">
                                                <option selected disabled>Code</option>
                                                @foreach($products as $product)
                                                    @foreach($product["product_code"] as $item)
                                                        <option value="{{$item . '-' . $product['invoice_number']}}">{{$item . " - Invoice: " . $product["invoice_number"]}}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            @else
                                            <select id="productCode" class="select2 form-control">
                                                <option selected disabled>--PRODUCT CODE--</option>
                                                <option value="NO OUTLETS">"NO PRODUCT CODES"</option>
                                            </select>
                                            @endif
                                        </td>
                                        <td id="p_name1">NIL</td>
                                        <td name="pkgSize" id="pkgSize{{1}}">NIL</td>
                                        <td id="pkgType1">NIL</td>
                                        <td id="org_price">
                                            <input name="original_price" disabled id="original_price1" type="text"
                                                size="5" value="">
                                        </td>
                                        <td id="new_p">
                                            <input name="new_price" id="new_price{{1}}"
                                                onkeyup="checkNewPrice(this); calculate_total(1);" value="" type="text"
                                                size="5">
                                            <small></small>
                                        </td>
                                        <td id="p_quantity">
                                            <input name="quantity" id="quantity{{1}}"
                                                onkeyup="checkQuantity(this); calculate_total(1);" type="text" size="5"
                                                value="">
                                            <small></small>
                                        </td>
                                        <td id="amt1">0</td>
                                        <td style="flex:1;" class="text-left" style='white-space: nowrap'>
                                            <button id="add" onclick="add_row();" type="button"
                                                class="btn btn-sm btn-success w-100">Add</button>
                                            <button id="delete" onclick="delete_row(this, 1);" type="button"
                                                class="btn btn-sm btn-danger w-100">Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br><br>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-4">
                                <div class="form-group form-field">
                                    <label for="total-amount">Total Amount</label>
                                    <input disabled style="border: solid 1px" value={{0}} type="text" name="totalAmount"
                                        id="total-amount" class="form-control">
                                    <small></small>
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group form-field">
                                    <label for="amount-paid">Amount Paid</label>
                                    <input onkeyup="calcDueAmount(this); checkReceivedAmount(this)"
                                        style="border: solid 1px" value={{0}} id="amount-paid" type="text"
                                        class="form-control" name="amountPaid">
                                    <small></small>
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group form-field">
                                    <label for="due-amount">Remaining Amount</label>
                                    <input disabled style="border: solid 1px" value={{0}} id="due-amount" type="text"
                                        class="form-control" name="dueAmount">
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button id="addSale" class="btn btn-success mr-1">Add Sale</button>
                                <button type="reset" class="btn btn-light-secondary" data-dismiss="modal"
                                    onClick="window.location.reload();">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
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
<script src="{{ asset('vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('vendors/js/pickers/pickadate/legacy.js') }}"></script>
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
<script src="{{ asset('js/scripts/addSale.js') }}"></script>
<script>
    function add_row() {
        var id = Math.floor(Math.random() * 10001);
        var table = document.getElementById("data_table");
        var body = document.getElementById("body");
        var row = table.insertRow(-1);
        row.id = "row" + id;
        var cell1 = document.createElement("td");
        var cell2 = document.createElement("td");
        var cell3 = document.createElement("td");
        var cell4 = document.createElement("td");
        var cell5 = document.createElement("td");
        var cell6 = document.createElement("td");
        var cell7 = document.createElement("td");
        var cell8 = document.createElement("td");
        var cell9 = document.createElement("td");

        // disables the delete button based on the number of rows
        const rows = table.rows.length - 1;
        const childElements = table.rows[1].cells[8].childNodes;
        const delBTN = childElements[3];
        delBTN.disabled = false;

        cell1.innerHTML = `
            <form>
            <td class="text-right" style="width: 100px;">
                <div class="form-group">
                    @if($products != null || !empty($products))
                    <select name="product_code" id="productCode${id}" class="select2 form-control"
                    onchange="getState(this.value, ${id})" >                          
                        <option selected disabled>Code</option>
                        @foreach($products as $product)
                            @foreach($product["product_code"] as $item)
                                <option value="{{$item . '-' . $product['invoice_number']}}">{{$item . " - Invoice: " . $product["invoice_number"]}}</option>
                            @endforeach
                        @endforeach
                    </select>
                    @else
                    <select id="productCode${id}" class="select2 form-control" >                          
                        <option selected disabled>--PRODUCT CODE--</option>
                        <option value="NO OUTLETS">"NO PRODUCT CODES"</option>
                    </select>
                    @endif 
                </div>
            </td>
            </form>
        `;
        
        cell2.id = `p_name${id}`;
        cell2.innerHTML = "NIL";
        
        cell3.id = `pkgSize${id}`;
        cell3.innerHTML = "NIL";

        cell9.id = `pkgType${id}`;
        cell9.innerHTML = "NIL";

        cell4.innerHTML = `<input name="original_price" disabled id="original_price${id}" type="text" size="5" value="">`;
        cell5.innerHTML = `<input name="new_price" id="new_price${id}" onkeyup="checkNewPrice(this);" onkeyup="calculate_total(${id});" type="text" size="5"><small></small>`;
        cell6.innerHTML = `<input id="quantity${id}" type="text" onkeypress="checkQuantity(this);" onkeyup="calculate_total(${id});" size="5" value=""><small></small>`;
        
        cell7.id = `amt${id}`;
        cell7.innerHTML = '0';
        
        cell8.innerHTML = `
            <button id="add" onclick="add_row();" type="button" class="btn btn-sm btn-success w-100">Add</button>
            <button id="delete${id}" onclick="delete_row(this, ${id});" type="button" class="btn btn-sm btn-danger w-100">Remove</button>
        `;

        row.appendChild(cell1);
        row.appendChild(cell2);
        row.appendChild(cell3);
        row.appendChild(cell9);
        row.appendChild(cell4);
        row.appendChild(cell5);
        row.appendChild(cell6);
        row.appendChild(cell7);
        row.appendChild(cell8);
        body.appendChild(row);
    }

    function calculate_total(id) {
        var new_price = document.getElementById("new_price" + id);
        var quantity = document.getElementById("quantity" + id);
        var amount = document.getElementById("amt" + id);
        var original_price = document.getElementById("original_price" + id);
        var totalAmount = document.getElementById("total-amount");
        
        const table = document.getElementById("data_table");
        const count = table.rows.length;
        var totalSum = 0;
        
        if(quantity.value == "") {
            amount.innerHTML = 0;
        } else if (new_price.value == "" || new_price.value == "0") {
            amount.innerHTML = parseInt(quantity.value) * parseFloat(original_price.value);
        } else {
            amount.innerHTML = parseInt(quantity.value) * parseFloat(new_price.value);
        }
        
        for(var i = 1; i < count; i++) {
            totalSum += parseFloat(table.rows[i].cells[7].innerHTML);
        }

        totalAmount.value = totalSum;
    }
</script>
@endsection