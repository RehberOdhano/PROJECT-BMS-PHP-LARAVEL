<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<body>
    <h1>Beverages Pakistan Ltd</h1>
    <p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
    <p>Phone: (+92) 124 545690</p>
    <hr>
    <div class="row">
        <div style="text-align: right">
            <div class="col-md-6 col-12">
                <h3>Invoice Number</h3>
                <h4 style="margin-top: -10px">{{$invoice_num}}</h4>
            </div>
            <div class="col-md-6 col-12">
                <h3>Date</h3>
                <h4 style="margin-top: -10px">{{date('d-m-Y', strtotime(substr($date, 0, 10)))}}</h4>
            </div>
        </div>
    </div>
    <hr>

    <div class="table-responsive">
        <table class="table" style="paddding:10px;">
            <thead>
                <th style="padding: 6px;">Code</th>
                <th style="padding: 6px;">Product Name</th>
                <th style="padding: 6px;">Quantity</th>
                <th style="padding: 6px;">Unit Price</th>
                <th style="padding: 6px;">Adv. Income Tax</th>
                <th style="padding: 6px;">Regular Discount</th>
                <th style="padding: 6px;">Rate</th>
                <th style="padding: 6px;">Amount</th>
            </thead>
            <tbody>
                @for($i = 0; $i < count($productCodes); $i++) <tr>
                    <td style="padding: 5px;">{{$productCodes[$i]}}</td>
                    <td style="padding: 5px;">{{$productNames[$i]}}</td>
                    @if($quantities[$i] == 0)
                    <td style="padding: 5px;">NOT IN STOCK</td>
                    <td style="padding: 5px;">NIL</td>
                    <td style="padding: 5px;">NIL</td>
                    @else
                    <td style="padding: 7px;">{{ $quantities[$i] }} Bottles</td>
                    <td style="padding: 7px;">Rs.{{ $unitPrices[$i] }}</td>
                    <td style="padding: 8px;">{{ $advIncomeTaxes[$i] }}%</td>
                    <td style="padding: 8px;">{{ $regDiscounts[$i] }}%</td>
                    <td style="padding: 5px;">Rs.{{$unitPrices[$i] * $quantities[$i] }}</td>
                    <td style="padding: 5px;">Rs.{{$totalAmounts[$i]}}</td>
                    @endif
                    </tr>
                    @endfor
            </tbody>
        </table>
    </div>
    <hr>
    <div class="row">
        <div style="text-align: right">
            <h3>Grand Total: {{$grandTotal}}</h3>
        </div>
    </div>

</body>

</html>