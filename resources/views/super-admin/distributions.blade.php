@extends('layouts.super-admin.contentLayoutMaster')
{{-- title --}}
@section('title','Distributions')

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection

@section('content')
<!-- Knowledge base Jumbotron start -->
<section id="breadcrumb-rounded-divider" class="mb-2">
  <div class="row">
    <div class="col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded-pill breadcrumb-divider">
          <li class="breadcrumb-item"><a href="/superadmin/dashboard"><i class="bx bx-home"></i></a></li>
          <li class="breadcrumb-item active" aria-current="page">Distributions</li>
        </ol>
      </nav>
    </div>
  </div>
  </div>
</section>
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Distributions</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Distributions</span>
      </button>
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
  @elseif(session('block'))
  <div class="alert alert-danger">
    {{Session::pull('block')}}
  </div>
  @elseif(session('unblock'))
  <div class="alert alert-success">
    {{Session::pull('unblock')}}
  </div>
  @elseif(session('cannot block'))
  <div class="alert alert-warning">
    {{Session::pull('cannot block')}}
  </div>
  @elseif(session('warning'))
  <div class="alert alert-warning">
    {{Session::pull('warning')}}
  </div>
  @elseif(session('error'))
  <div class="alert alert-danger">
    {{Session::pull('error')}}
  </div>
  @endif
</section>
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header">
          <h2 class="card-title">Distributions</h2>
        </div> --}}
        <div class="card-body card-dashboard">
          <div class="table-responsive">

            {{-- <div class="col-md-6 col-12">
              <form action="/superadmin/dists/search">
                <div class="form-group">
                  <label class="text-bold-600" for="search">Search</label>
                  <input name="query" id="search" type="text" class="search_input" value="" autocomplete="search"
                    placeholder="Search distributions here...">
                </div>
              </form>
            </div> --}}

            <table class="table zero-configuration distTable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Admin</th>
                  <th>Contact</th>
                  <th>Address</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>

              <tbody>
                @foreach($distributions as $dist)
                <tr>
                  <td>{{$dist["name"]}}</td>
                  @if($dist["admin"] == null)
                  <td>NIL</td>
                  @else
                  <td>{{$dist['admin']}}</td>
                  @endif
                  <td>{{$dist["contact"]}}</td>
                  <td>{{$dist["address"]}}</td>
                  @if($dist["status"] == NULL)
                  <td>NIL</td>
                  @elseif($dist["status"] == 'BLOCKED')
                  <td class="text-danger font-weight-bold text-uppercase text-left-align">{{$dist["status"]}}</td>
                  @elseif($dist["status"] == 'Pending')
                  <td class="text-warning font-weight-bold text-uppercase text-left-align">{{$dist["status"]}}</td>
                  @else
                  <td class="text-success font-weight-bold text-uppercase text-left-align">{{$dist["status"]}}</td>
                  @endif
                  <td class="text-center py-1">
                    <div class="dropup" style="padding-top: 10px;">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        @if($dist["status"] == "BLOCKED")
                        <a id="unblock" class="dropdown-item" id="confirm-text"
                          href="/superadmin/dists/unblock/{{$dist['id']}}"
                          data-target="#unblock-<?php echo $dist['id']; ?>" data-toggle="modal"><i
                            class="fa-solid fa-unlock" style="margin-right: 15px;"></i> unblock</a>
                        @elseif(($dist['status'] == "Paid" || $dist['status'] == "Pending" || $dist['status'] == null)
                        && ($dist['admin'] == null))
                        <a id="add_admin" class="dropdown-item" id="confirm-text"
                          href="/superadmin/dists/add/admin/{{$dist['id']}}"
                          data-target="#add_admin-<?php echo $dist['id']; ?>" data-toggle="modal"><i
                            class="fa-solid fa-user-plus" style="margin-right: 20px;"></i></i> add admin</a>
                        <a id="add_payment" class="dropdown-item" id="confirm-text"
                          href="/superadmin/payments/add/{{$dist['id']}}"
                          data-target="#add_payment-<?php echo $dist['id']; ?>" data-toggle="modal"><i
                            class="fa-solid fa-money-check-dollar" style="margin-right: 20px;"></i> add payment</a>
                        <a id="edit" class="dropdown-item" href="/superadmin/dists/edit/{{$dist['id']}}"
                          data-target="#edit-Distributions-<?php echo $dist['id']; ?>" data-toggle="modal"><i
                            class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a id="block" class="dropdown-item" id="confirm-text"
                          href="/superadmin/dists/block/{{$dist['id']}}" data-target="#block-<?php echo $dist['id']; ?>"
                          data-toggle="modal"><i class="fa-solid fa-ban" style="margin-right: 20px;"></i> block </a>
                        <a id="remove" class="dropdown-item" id="confirm-text"
                          href="/superadmin/dists/delete/{{$dist['id']}}"
                          data-target="#delete-<?php echo $dist['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                        @else
                        <a id="add_payment" class="dropdown-item" id="confirm-text"
                          href="/superadmin/payments/add/{{$dist['id']}}"
                          data-target="#add_payment-<?php echo $dist['id']; ?>" data-toggle="modal"><i
                            class="fa-solid fa-money-check-dollar" style="margin-right: 20px;"></i> add payment</a>
                        <a id="edit" class="dropdown-item" href="/superadmin/dists/edit/{{$dist['id']}}"
                          data-target="#edit-Distributions-<?php echo $dist['id']; ?>" data-toggle="modal"><i
                            class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a id="block" class="dropdown-item" id="confirm-text"
                          href="/superadmin/dists/block/{{$dist['id']}}" data-target="#block-<?php echo $dist['id']; ?>"
                          data-toggle="modal"><i class="fa-solid fa-ban" style="margin-right: 20px;"></i> block </a>
                        <a id="remove" class="dropdown-item" id="confirm-text"
                          href="/superadmin/dists/delete/{{$dist['id']}}"
                          data-target="#delete-<?php echo $dist['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                        @endif
                      </div>
                    </div>
                  </td>

                  {{-- Add Admin Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="add_admin-<?php echo $dist['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Add Admin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="distAdminForm{{$dist['id']}}" class="form" method="POST"
                              action="{{URL('/superadmin/dists/add/admin/'.$dist['id'])}}">
                              @csrf
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="name">Name</label>
                                      <input type="text" id="name{{$dist['id']}}" value="" class="form-control"
                                        placeholder="Name" name="name"
                                        onfocusout="checkInputField(this, {{$dist['id']}})"
                                        onkeyup="checkDistAdminName(this)">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="email">Email</label>
                                      <input type="text" onkeyup="checkDistAdminEmail(this)" id="email{{$dist['id']}}"
                                        value="" class="form-control" placeholder="Eamil" name="email"
                                        onfocusout="checkInputField(this, {{$dist['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="password{{$dist['id']}}">Password</label>
                                      <input type="password" id="password{{$dist['id']}}" value="" class="form-control"
                                        placeholder="Password" name="password"
                                        onfocusout="checkInputField(this, {{$dist['id']}})"
                                        onkeyup="checkDistAdminPassword(this)">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="confirm_pass{{$dist['id']}}">Confirm Password</label>
                                      <input type="password" id="confirm_pass{{$dist['id']}}" value=""
                                        class="form-control" placeholder="Confirm Password" name="confirm_pass"
                                        onfocusout="checkInputField(this, {{$dist['id']}})"
                                        onkeyup="checkConfirmPassword(this, {{$dist['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="contact">Contact</label>
                                      <input type="text" id="contact{{$dist['id']}}" value="" class="form-control"
                                        placeholder="Contact" name="contact"
                                        onfocusout="checkInputField(this, {{$dist['id']}})"
                                        onkeyup="checkDistAdminContact(this)">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="city">City</label>
                                      <input type="text" id="city{{$dist['id']}}" value="" class="form-control"
                                        placeholder="City" name="city"
                                        onfocusout="checkInputField(this, {{$dist['id']}})"
                                        onkeyup="checkDistAdminCity(this)">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-12 d-flex justify-content-end">
                                    <button onclick="submitAdminForm({{$dist['id']}})" type="submit"
                                      class="btn btn-success mr-1">Add</button>
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

                  {{-- Change Admin Modal --}}
                  {{-- <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="change_admin-<?php echo $dist['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Change Admin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="distAdminForm{{" 1".$dist['id']}}" class="form" method="POST"
                              action="{{URL('/superadmin/dists/change/admin/'.$dist['id'])}}">
                              @csrf
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-6 col-6">
                                    <label for="admin{{" 1".$dist['id']}}">Which Admin to Change</label>
                                    @if($admins != null || !empty($admins))
                                    <select name="admin" id="admin{{" 1".$dist['id']}}" class="select2 form-control"
                                      onchange="checkDistAdminEmail({{'1'.$dist['id']}})"
                                      onfocusout="checkInputField(this, {{$dist['id']}})">
                                      @for($i = 0; $i < count($admins[$dist['id']]); $i++) <option
                                        value={{$admins[$dist['id']][$i]}}>{{$admins[$dist['id']][$i]}}</option>
                                        @endfor
                                    </select>
                                    @else
                                    <select id="admin{{" 1".$dist['id']}}" class="select2 form-control">
                                      <option selected disabled>--Admins--</option>
                                      <option value="NO OUTLETS">"NO ADMINS"</option>
                                    </select>
                                    @endif
                                    <small></small>
                                  </div>
                                  <div class="col-6 d-flex justify-content-end">
                                    <button onclick="submitAdminForm({{'1'.$dist['id']}})" type="submit"
                                      class="btn btn-success mr-1">Change</button>
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


                  {{-- Add Payment Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="add_payment-<?php echo $dist['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Add Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="distPaymentForm{{$dist['id']}}" class="form" method="POST"
                              action="{{URL('/superadmin/payments/add/'.$dist['id'])}}">
                              @csrf
                              <div class="form-body d-flex flex-column justify-content-around">
                                <div class="row">
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="amountPaid">Amount Paid</label>
                                      <input type="text" id="amountPaid{{$dist['id']}}" value="" class="form-control"
                                        placeholder="Amount paid" name="amount_paid" onkeyup="checkAmountPaid(this)"
                                        onfocusout="checkInputField(this, {{$dist['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="amountDue">Amount Due</label>
                                      <input type="text" id="amountDue{{$dist['id']}}" value="" class="form-control"
                                        placeholder="Amount Due" name="amount_due"
                                        onkeyup="checkAmountDue(this, {{$dist['id']}})"
                                        onfocusout="checkInputField(this, {{$dist['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="status">Payment Status</label>
                                      <input type="text" disabled id="status{{$dist['id']}}" value=""
                                        class="form-control" placeholder="Status" name="status"
                                        onchange="checkStatus(this)"
                                        onfocusout="checkInputField(this, {{$dist['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-6 col-12">
                                    <div class="form-group form-field">
                                      <label for="payment_date">Payment Date</label>
                                      <fieldset class="form-group position-relative has-icon-left">
                                        <input type="date" id="payment_date{{$dist['id']}}" name="date_amount_paid"
                                          class="form-control date_picker datepicker-input" placeholder="Payment Date"
                                          onkeyup="checkPaymentDate(this)"
                                          onfocusout="checkInputField(this, {{$dist['id']}})">
                                        <div class="form-control-position">
                                          <i class='bx bx-calendar'></i>
                                        </div>
                                        <small></small>
                                      </fieldset>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                      <button onclick="submitDistPaymentForm({{$dist['id']}})" type="submit"
                                        class="btn btn-success mr-1">Add Payment</button>
                                      <button type="reset" class="btn btn-light-secondary"
                                        data-dismiss="modal">Cancel</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  {{-- Edit Distributions Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="edit-Distributions-<?php echo $dist['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Edit Distributions</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="distForm{{$dist['id']}}" class="form" method="POST"
                              action="{{URL('/superadmin/dists/edit/'.$dist['id'])}}">
                              @csrf
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="distName{{$dist['id']}}">Name</label>
                                      <input type="text" onkeyup="checkDistName(this)" id="distName{{$dist['id']}}"
                                        value={{$dist["name"]}} class="form-control" name="dist_name"
                                        onfocusout="checkInputField(this, {{$dist['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="distContact{{$dist['id']}}">Contact</label>
                                      <input type="text" id="distContact{{$dist['id']}}"
                                        onkeyup="checkDistContact(this)" value={{$dist['contact']}} class="form-control"
                                        name="dist_contact" onfocusout="checkInputField(this, {{$dist['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="distAddress{{$dist['id']}}">Address</label>
                                      <input type="text" id="distAddress{{$dist['id']}}"
                                        onkeyup="checkDistAddress(this)" value="{{$dist['address']}}"
                                        class="form-control" name="dist_address"
                                        onfocusout="checkInputField(this, {{$dist['id']}})">
                                      <small></small>
                                    </div>
                                  </div>

                                  <div class="col-12 d-flex justify-content-end">
                                    <button onclick="submitDistForm({{$dist['id']}})" type="submit"
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

                  {{-- DELETE MODAL --}}
                  <div class="modal fade text-left" id="delete-<?php echo $dist['id']; ?>" tabindex="-1" role="dialog"
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
                          <form class="form" action="{{URL('superadmin/dists/delete/'.$dist['id'])}}" method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                    </p>
                                    <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                      value="{{$dist['id']}}">
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

                  {{-- UNBLOCK MODAL --}}
                  <div class="modal fade text-left" id="unblock-<?php echo $dist['id']; ?>" tabindex="-1" role="dialog"
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
                          <form class="form" action="{{URL('superadmin/dists/unblock/'.$dist['id'])}}" method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to unblock this
                                      distribution?</p>
                                    <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                      value="{{$dist['id']}}">
                                  </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                  <button type="submit" class="btn btn-danger mr-1">Unblock</button>
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

                  {{-- BLOCK MODAL --}}
                  <div class="modal fade text-left" id="block-<?php echo $dist['id']; ?>" tabindex="-1" role="dialog"
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
                          <form class="form" action="{{URL('superadmin/dists/block/'.$dist['id'])}}" method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to block this
                                      distribution?</p>
                                    <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                      value="{{$dist['id']}}">
                                  </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                  <button type="submit" class="btn btn-danger mr-1">Block</button>
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
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Add Distributions Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Distribution</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="distForm{{-1}}" class="form" method="POST" action="/superadmin/dists/add">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="distName{{-1}}">Distribution Name</label>
                    <input type="text" id="distName{{-1}}" value="" class="form-control" placeholder="Distribution Name"
                      name="dist_name" onkeyup="checkDistName(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="distContact{{-1}}">Distribution Contact</label>
                    <input type="text" id="distContact{{-1}}" value="" class="form-control"
                      placeholder="Distribution Contact" name="dist_contact" onkeyup="checkDistContact(this)"
                      onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="distAddress{{-1}}">Distribution Address</label>
                    <input type="text" id="distAddress{{-1}}" value="" class="form-control"
                      placeholder="Distribution Address" name="dist_address" onkeyup="checkDistAddress(this)"
                      onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitDistForm({{-1}})" type="submit" class="btn btn-success mr-1">Add
                    Distribution</button>
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
<script src="{{asset('/js/addEditDist.js')}}"></script>
<script src="{{asset('/js/addDistAdmin.js')}}"></script>
<script src="{{asset('/js/addEditPayment.js')}}"></script>
<script src="{{asset('/js/disableDates.js')}}"></script>
<script type="text/javascript">
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "admin" + id:
        checkDistAdminEmail(element);
        break;
      case "name" + id:
        checkDistAdminName(element);
        break;
      case "email" + id:
        checkDistAdminEmail(element);
        break;
      case "password" + id:
        checkDistAdminPassword(element);
        break;
      case "confirm_pass" + id:
        checkConfirmPassword(element, id);
        break;
      case "contact" + id:
        checkDistAdminContact(element);
        break;
      case "city" + id:
        checkDistAdminCity(element);
        break;
      case "distName" + id:
        checkDistName(element);
        break;
      case "distAddress" + id:
        checkDistAddress(element);
        break;
      case "distContact" + id:
        checkDistContact(element);
        break;
      case "amountPaid" + id:
        checkAmountPaid(element);
        break;
      case "amountDue" + id:
        checkAmountDue(element);
        break;
      case "status" + id:
        checkStatus(element);
        break;
    }
  }
</script>
@endsection