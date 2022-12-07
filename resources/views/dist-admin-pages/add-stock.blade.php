@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title', 'Add Stock')

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
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/add-stock-table.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
                    <li class="breadcrumb-item active" aria-current="page">Add Stock</li>
                </ol>
            </nav>
        </div>
    </div>
    </div>
</section>
{{-- <section class="kb-search">
    <div class="row">
        <div class="col d-flex justify-content-between">
            <h2>Sales</h2>
            <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
                    class="bx bx-plus"></i>
                <span class="align-middle ml-25">Add Sales</span></button>
        </div>
    </div>
</section> --}}

{{-- Add Stock Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block" style="margin-left: -35px">
    <!--Success theme Modal -->
    <div class="modal-success mr-1 mb-1 d-inline-block">
        <div class="modal-body">
            <form id="stockForm" class="form" method="POST" enctype="multipart/form-data"
                action="/dists/admin/addStock">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group form-field">
                                <label for="date">Date</label>
                                <fieldset class="form-group position-relative has-icon-left">
                                    <input onchange="checkDate(this)" onclick="checkDate(this)" name="date" type="date"
                                        id="date{{-1}}" class="form-control date_picker" placeholder="Date">
                                    <div class="form-control-position">
                                        <i class='bx bx-calendar'></i>
                                    </div>
                                    <small></small>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group form-field">
                                <label for="invoice_num">Invoice Number</label>
                                <input onkeyup="checkInvoiceNumber(this)" type="text" id="invoice_num{{-1}}"
                                    class="form-control" placeholder="Invoice number" name="invoice_num">
                                <small></small>
                            </div>
                        </div>
                        <div style="margin-top: 20px;">
                            <table style="paddding:4px;" id="data_table" class="table table-hover table-dark">
                                <thead>
                                    <tr>
                                        <th style="width:100px;" scope="col">Product Code</th>
                                        <th style="width:100px; padding: 8px;" scope="col">Product Name</th>
                                        <th style="width:100px;" scope="col">Size</th>
                                        <th style="width:100px; padding: 8px;" scope="col">Type</th>
                                        <th style="width:100px; padding: 8px;" scope="col">Unit Price</th>
                                        <th style="width:100px; padding: 8px;" scope="col">Advance Income Tax</th>
                                        <th style="width:100px; padding: 8px;" scope="col">Regular Discount</th>
                                        <th style="width:100px; padding: 8px;" scope="col">Quantity</th>
                                        <th style="width:100px; padding: 8px;" scope="col">Total Amount</th>
                                        <th style="width:100px; padding: 8px;" scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="body">
                                    <tr id="row">
                                        <td id="code_opt">
                                            @if($products != null || !empty($products))
                                            <select name="product_code" id="productCode" class="select2 form-control"
                                                onchange="getState(this.value, -1)">
                                                <option selected disabled>Code</option>
                                                @foreach($products as $product)
                                                <option value={{$product["product_code"]}}>{{$product["product_code"]}}
                                                </option>
                                                @endforeach
                                            </select>
                                            @else
                                            <select id="productCode" class="select2 form-control">
                                                <option selected disabled>--PRODUCT CODE--</option>
                                                <option value="NO OUTLETS">"NO PRODUCT CODES"</option>
                                            </select>
                                            @endif
                                            <small></small>
                                        </td>
                                        <td id="p_name{{-1}}">NIL</td>
                                        <td id="pkgSize{{-1}}">NIL</td>
                                        <td id="pkgType{{-1}}">NIL</td>
                                        <td id="unit_price">
                                            <input name="unit_price" disabled id="unitprice{{-1}}" type="text" size="5"
                                                value="">
                                            <small></small>
                                        </td>
                                        <td id="advanceIncomeTax">
                                            <input name="advanceIncomeTax" id="tax{{-1}}"
                                                onkeyup="checkAdvanceIncomeTax(this); calculate_total(-1);" type="text"
                                                size="5" value="">
                                            <small></small>
                                        </td>
                                        <td id="regDiscount">
                                            <input name="regDiscount" id="discount{{-1}}"
                                                onkeyup="checkDiscount(this); calculate_total(-1);" type="text" size="5"
                                                value="">
                                            <small></small>
                                        </td>
                                        <td id="p_quantity">
                                            <input name="quantity" id="quantity{{-1}}"
                                                onkeyup="checkQuantity(this); calculate_total(-1);" type="text" size="5"
                                                value="">
                                            <small></small>
                                        </td>
                                        <td id="amt{{-1}}">0</td>
                                        <td style="flex:1;" class="text-left" style='white-space: nowrap'>
                                            <button id="add" onclick="add_row();" type="button"
                                                class="btn btn-sm btn-success w-100">Add</button>
                                            <button id="delete{{-1}}" onclick="delete_row(this);" type="button"
                                                class="btn btn-sm btn-danger w-100">Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br><br>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button id="addStockForm" class="btn btn-success mr-1">Add Stock</button>
                            <button onClick="window.location.reload();" type="reset" class="btn btn-light-secondary"
                                data-dismiss="modal">Cancel</button>
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
<script src="{{ asset('js/addStock.js') }}"></script>
<script src="{{ asset('js/disableDates.js') }}"></script>
<script>
    function add_row() {
            var id = Math.floor(Math.random() * 10001);
            var table = document.getElementById("data_table");
            var body = document.getElementById("body");
            var row = table.insertRow(-1);
            row.id = "del_row" + id;
            var cell1 = document.createElement("td");
            var cell2 = document.createElement("td");
            var cell3 = document.createElement("td");
            var cell4 = document.createElement("td");
            var cell5 = document.createElement("td");
            var cell6 = document.createElement("td");
            var cell7 = document.createElement("td");
            var cell8 = document.createElement("td");
            var cell9 = document.createElement("td");
            var cell10 = document.createElement("td");

            // disables the delete button based on the number of rows
            // if the total number of rows in table is 1, then we'll disable the 
            // delete button of that row...
            const rows = table.rows.length - 1;
            const childElements = table.rows[1].cells[9].childNodes;
            const delBTN = childElements[3];
            console.log(delBTN);
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
                                <option value={{$product["product_code"]}}>{{$product["product_code"]}}</option>
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

            cell10.id = `pkgType${id}`;
            cell10.innerHTML = "NIL";

            cell4.innerHTML = `
                <input name="unit_price" disabled id="unitprice${id}" type="text" size="5" value="">
                <small></small>
            `;
            
            cell8.innerHTML = `
                <input name="advanceIncomeTax" id="tax${id}" onkeypress="checkAdvanceIncomeTax(this, ${id})" onkeyup="calculate_total(${id});" type="text" size="5" value="">
                <small></small>
            `;
            
            cell9.innerHTML = `
                <input name="regDiscount" id="discount${id}" onkeypress="checkDiscount(this, ${id})" onkeyup="calculate_total(${id});" type="text" size="5" value="">
                <small></small>
            `;
 
            cell5.innerHTML = `
                <input id="quantity${id}" onkeypress="checkQuantity(this)" onkeyup="calculate_total(${id});" type="text" size="5" value="">
                <small></small>
            `;
            
            cell6.id = `amt${id}`;
            cell6.innerHTML = '0';
            
            cell7.innerHTML = `
                <button id="add" onclick="add_row();" type="button" class="btn btn-sm btn-success  w-100">Add</button>
                <button id="delete${id}" onclick="delete_row(this);" type="button" class="btn btn-sm btn-danger  w-100">Remove</button>
            `;

            row.appendChild(cell1);
            row.appendChild(cell2);
            row.appendChild(cell3);
            row.appendChild(cell10);
            row.appendChild(cell4);
            row.appendChild(cell8);
            row.appendChild(cell9);
            row.appendChild(cell5);
            row.appendChild(cell6);
            row.appendChild(cell7);
            body.appendChild(row);
        }

        // this function will calculate the total amount of an product, added in the stock,
        // after adjusting the tax and regular discount accordingly...
        function calculate_total(id) {
            var unit_price = document.getElementById("unitprice" + id);
            var quantity = document.getElementById("quantity" + id);
            var amount = document.getElementById("amt" + id);
            var regDiscout = parseFloat(document.getElementById("discount" + id).value)/100;
            var advanceIncomeTax = parseFloat(document.getElementById("tax" + id).value)/100;
            if(quantity.value == "") {
                amount.innerHTML = 0;
            } else {
                var totalCost = parseFloat(unit_price.value) * parseInt(quantity.value);
                if((isNaN(regDiscout) || regDiscout == 0) && (!isNaN(advanceIncomeTax) || advanceIncomeTax != 0)) {
                    amount.innerHTML = (totalCost * advanceIncomeTax) + totalCost;
                } else if((!isNaN(regDiscout) || regDiscout != 0) && (isNaN(advanceIncomeTax) || advanceIncomeTax == 0)) {
                    amount.innerHTML = totalCost - (totalCost * regDiscout);
                } else if((isNaN(regDiscout) || regDiscout == 0) && (isNaN(advanceIncomeTax) || advanceIncomeTax == 0)) {
                    amount.innerHTML = totalCost;
                } else {
                    totalCost += (totalCost * advanceIncomeTax); // tax is added
                    totalCost -= (totalCost * regDiscout); // discount is deducted
                    amount.innerHTML = totalCost;
                }
            }
        }
</script>
@endsection