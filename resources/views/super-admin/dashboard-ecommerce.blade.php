@extends('layouts.super-admin.contentLayoutMaster')
{{-- page Title --}}
@section('title','Superadmin - Dashboard E-commerce')
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
                    <i class="bx bx-user font-medium-5"></i>
                  </div>
                  <div class="text-muted line-ellipsis">Total Admins</div>
                  <h3 class="mb-0">{{$totalAdmins}}</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-12 dashboard-users-danger">
              <div class="card text-center">
                <div class="card-body py-1">
                  <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto mb-50">
                    <i class="bx bx-credit-card-alt font-medium-5"></i>
                  </div>
                  <div class="text-muted line-ellipsis">Total Payments</div>
                  <h3 class="mb-0">{{$total_payments}}</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-12 dashboard-users-danger">
              <div class="card text-center">
                <div class="card-body py-1">
                  <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">
                    <i class="bx bx-user font-medium-5"></i>
                  </div>
                  <div class="text-muted line-ellipsis">Total Users</div>
                  <h3 class="mb-0">{{$totalUsers}}</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-12 dashboard-users-danger">
              <div class="card text-center">
                <div class="card-body py-1">
                  <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto mb-50">
                    <i class="bx bx-building font-medium-5"></i>
                  </div>
                  <div class="text-muted line-ellipsis">Total Distributions</div>
                  <h3 class="mb-0">{{$total_distributions}}</h3>
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
    <div class="col-xl-6 col-12 dashboard-marketing-campaign">
      <div class="card marketing-campaigns">
        <form method="GET" action="/superadmin/admins">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Admins</h4>
            <button type="submit" class="btn btn-sm btn-primary glow ">View All</button>
          </div>
        </form>
        <div class="table-responsive">
          <!-- table start -->
          <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($admins as $admin)
              <tr>
                <td class="py-1 line-ellipsis">
                  <img class="rounded-circle mr-1" src="{{asset('images/profile/portraits/avatar-portrait-1.jpg')}}"
                    alt="card" height="24" width="24">{{$admin["name"]}}
                </td>
                <td class="py-1">
                  {{$admin["email"]}}
                </td>
                @if($admin["status"] == "BLOCKED")
                <td class="d-flex badge badge-danger"
                  style="margin-top:15px; margin-left: 20px; max-width: 60%; padding: 5px; justify-content: center; align-items: center;">
                  {{$admin["status"]}}
                </td>
                @else
                <td class="d-flex badge badge-success"
                  style="margin-top:15px; margin-left: 20px; max-width: 60%; padding: 5px; justify-content: center; align-items: center;">
                  Active
                </td>
                @endif
                {{-- <td class="py-1">
                  <i class="bx bx-trending-up text-success align-middle mr-50"></i><span>30%</span>
                </td> --}}
                {{-- <td class="text-success py-1">{{$user["status"]}}</td> --}}
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- table ends -->
        </div>
      </div>
    </div>

    <div class="col-xl-6 col-12 dashboard-marketing-campaign">
      <div class="card marketing-campaigns">
        <form method="GET" action="/superadmin/distributions">
          <div class="card-header d-flex justify-content-between align-items-center pb-1">
            <h4 class="card-title">Distributions</h4>
            <button type="submit" class="btn btn-sm btn-primary glow ">View All</button>
          </div>
        </form>
        <div class="table-responsive">
          <!-- table start -->
          <table id="table-marketing-campaigns" class="table table-borderless table-marketing-campaigns mb-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($distributions as $dist)
              <tr>
                <td class="py-1 line-ellipsis">
                  <img class="rounded-circle mr-1" src="{{asset('images/profile/portraits/avatar-portrait-1.jpg')}}"
                    alt="card" height="24" width="24">{{$dist["name"]}}
                </td>
                <td class="py-1">
                  {{$dist["address"]}}
                </td>
                @if($dist["status"] == "BLOCKED")
                <td class="d-flex badge badge-danger"
                  style="margin-top:15px; margin-left: 20px; max-width: 60%; padding: 5px; justify-content: center; align-items: center;">
                  {{$dist["status"]}}
                </td>
                @else
                <td class="d-flex badge badge-success"
                  style="margin-top:15px; margin-left: 20px; max-width: 60%; padding: 5px; justify-content: center; align-items: center;">
                  Active
                </td>
                {{-- @else
                <td class="text-success py-1">
                  {{$dist["status"]}}
                </td> --}}
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
          <!-- table ends -->
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