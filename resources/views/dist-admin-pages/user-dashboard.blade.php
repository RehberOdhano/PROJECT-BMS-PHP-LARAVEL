@extends('layouts.contentLayoutMaster')
{{-- page Title --}}
@if(session()->has('user'))
@section('title','User - Dashboard E-commerce')
@endif
{{-- vendor css --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/charts/apexcharts.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard-ecommerce.css')}}">
@endsection

@section('content')
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">

  <div class="row">
    <div class="col-xl-12 col-12 dashboard-users">
      <div class="row  ">
        <!-- Statistics Cards Starts -->
        <div class="col-12">
          <div class="row">
            <div class="col-sm-3 col-12 dashboard-users-success">
              <div class="card text-center">
                <div class="card-body py-1">
                  <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                    <i class="bx bx-line-chart font-medium-5"></i>
                  </div>
                  <div class="text-muted line-ellipsis">Total Sales</div>
                  <h3 class="mb-0">{{$total_sales}}</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-12 dashboard-users-danger">
              <div class="card text-center">
                <div class="card-body py-1">
                  <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto mb-50">
                    <i class="bx bx-user font-medium-5"></i>
                  </div>
                  <div class="text-muted line-ellipsis">Total Employees</div>
                  <h3 class="mb-0">{{$num_of_employees}}</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-12 dashboard-users-danger">
              <div class="card text-center">
                <div class="card-body py-1">
                  <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                    <i class="bx bx-building font-medium-5"></i>
                  </div>
                  <div class="text-muted line-ellipsis">Outlets</div>
                  <h3 class="mb-0">{{$num_of_outlets}}</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-12 dashboard-users-danger">
              <div class="card text-center">
                <div class="card-body py-1">
                  <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto mb-50">
                    <i class="bx bx-package font-medium-5"></i>
                  </div>
                  <div class="text-muted line-ellipsis">Packages</div>
                  <h3 class="mb-0">{{$num_of_packages}}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Revenue Growth Chart Starts -->
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-sm-12">
      <div class="card widget-order-activity">
        <div class="card-header d-md-flex justify-content-between align-items-center">
          <h4 class="card-title">Sales Activity</h4>
          <div class="heading-elements mt-md-0 mt-50 d-flex align-items-center">
            <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-success">Monthly</button>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div id="order-activity-line-chart"></div>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-sm-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Top Selling Outlets</h4>
        </div>
        <p class="ml-2">Calculated for the last 2 month</p>
        <div class="card-body pb-1">
          <div class="d-flex justify-content-around align-items-center flex-wrap">
          </div>
          <div id="analytics-bar-chart" class="my-75"></div>
        </div>
      </div>

    </div>
  </div>
  <div class="row" id="table-head">
    <div class="col-md-6 col-sm-12">
      <div class="card">
        <form class="form" method="GET" action="/dists/admin/outlets">
          <div class="card-header d-flex justify-content-between">
            <h4 class="card-title"> Outlets</h4>
            <button type="submit" class="btn btn-sm btn-primary glow ">View All</button>
          </div>
        </form>

        <!-- table head dark -->
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-dark">
              <tr>
                <th>Name</th>
                <th>Contact</th>
                <th class="text-center">Address</th>
              </tr>
            </thead>
            <tbody>
              @foreach($outlets as $outlet)
              <tr>
                <td>{{$outlet["name"]}}</td>
                <td>{{$outlet["contact"]}}</td>
                <td>{{$outlet["address"]}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-6 col-sm-12">
      <div class="card">
        <form class="form" method="GET" action="/dists/admin/categories">
          <div class="card-header d-flex justify-content-between">
            <h4 class="card-title"> Categories</h4>
            <button type="submit" class="btn btn-sm btn-primary glow ">View All</button>
          </div>
        </form>
        <!-- table head dark -->
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-dark">
              <tr>
                <th>Name</th>
                {{-- <th>Available Stock</th> --}}
                <th class="text-center">Added on</th>
              </tr>
            </thead>
            <tbody>
              @foreach($categories as $category)
              <tr>
                <td>{{$category["category_name"]}}</td>
                {{-- <td>{{$category["available_stock"]}}</td> --}}
                <td class="text-center">{{date('d-m-Y', strtotime(substr($category["created_at"], 0, 10)))}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row" id="table-head">
    <div class="col-12">
      <div class="card">
        <form class="form" method="GET" action="/dists/admin/stocks">
          <div class="card-header d-flex justify-content-between">
            <h4 class="card-title"> Stocks</h4>
            <button type="submit" class="btn btn-sm btn-primary glow ">View All</button>
          </div>
        </form>
        <!-- table head dark -->
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-dark">
              <tr>
                <th>Delivery Date</th>
                <th>Invoice No.</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Package Type</th>
                <th>Package Size</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Regular Discount</th>
                <th>Advance Income Tax</th>
                <th>Total Amount</th>
              </tr>
            </thead>
            <tbody>
              @for($i = 0; $i < count($obj); $i++) @for($j=0; $j < count($obj[$ids[$i]][2]); $j++) <tr>
                <td>{{date('d-m-Y', strtotime(substr($obj[$ids[$i]][0], 0, 10)))}}</td> {{-- Date --}}
                <td>{{$obj[$ids[$i]][1]}}</td> {{-- Invoice No. --}}
                <td>{{($obj[$ids[$i]][2])[$j]}}</td> {{-- Product Code --}}
                <td>{{($obj[$ids[$i]][3])[$j]}}</td> {{-- Product Name --}}
                <td>{{($obj[$ids[$i]][4])[$j]}}</td> {{-- Pkg Type --}}
                <td>{{($obj[$ids[$i]][5])[$j]}}</td> {{-- Pkg Size --}}
                <td>Rs.{{($obj[$ids[$i]][6])[$j]}}</td> {{-- Unit Price --}}
                <td>{{($obj[$ids[$i]][9])[$j]}}</td> {{-- Quantity --}}
                <td>{{($obj[$ids[$i]][7])[$j]}}%</td> {{-- Regular Discount --}}
                <td>{{($obj[$ids[$i]][8])[$j]}}%</td> {{-- Tax --}}
                <td>Rs.{{($obj[$ids[$i]][10])[$j]}}</td> {{-- Total Amount --}}
                </tr>
                @endfor
                @endfor
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-scripts')
<script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
@endsection

@section('page-scripts')
{{-- <script src="{{asset('js/scripts/pages/dashboard-ecommerce.js')}}"></script> --}}
<script src="{{asset('js/scripts/pages/dashboard-analytics.js')}}"></script>
<script src="{{asset('js/scripts/cards/widgets.js')}}"></script>
<script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>


@endsection