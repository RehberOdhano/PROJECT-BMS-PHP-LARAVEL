@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Products')

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
          <li class="breadcrumb-item active" aria-current="page">Products</li>
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
  @elseif(session('warning'))
  <div class="alert alert-warning">
    {{Session::pull('warning')}}
  </div>
  @elseif(session('cantAddPkg'))
  <div class="alert alert-danger">
    {{Session::pull('cantAddPkg')}}
  </div>
  @endif
</section>
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Products</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Product</span></button>
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
                  <th>Product Code</th>
                  <th>Product Name</th>
                  <th>Package Name</th>
                  <th>Category</th>
                  <th>Flavor</th>
                  <th>Unit Price</th>
                  <th>Advance Income Tax</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($products))
                @foreach($products as $product)
                <tr>
                  <td>{{$product["product_code"]}}</td>
                  <td>{{$product["product_name"]}}</td>
                  <td>{{$product["pkg_name"]}}</td>
                  <td>{{$product["category"]}}</td>
                  <td>{{$product["flavor"]}}</td>
                  <td>Rs.{{$product["unit_price"]}}</td>
                  <td>{{$product["advance_income_tax"]}}%</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-package-<?php echo $product['id']; ?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $product['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>

                  {{-- Edit product Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="edit-package-<?php echo $product['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Edit Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="productForm{{$product['id']}}" class="form"
                              action="{{URL('/dists/admin/edit/product/'.$product['id'])}}" method="POST">
                              @csrf
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="code{{$product['id']}}">Product Code</label>
                                      <input type="text" id="code{{$product['id']}}" class="form-control"
                                        value="{{$product['product_code']}}" name="product_code"
                                        onkeyup="checkProductCode(this)"
                                        onfocusout="checkInputField(this, {{$product['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="name{{$product['id']}}">Product Name</label>
                                      <input type="text" id="name{{$product['id']}}" class="form-control"
                                        value="{{$product['product_name']}}" name="product_name"
                                        onkeyup="checkProductName(this)"
                                        onfocusout="checkInputField(this, {{$product['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="category{{$product['id']}}">Category</label>
                                      @if($categories != null || !empty($categories))
                                      <select name="category" id="category{{$product['id']}}"
                                        class="select2 form-control" onchange="checkCategoryName(this)">
                                        <option selected value="{{$product['category']}}">{{$product['category']}}
                                        </option>
                                        @foreach($categories as $category)
                                        @if($category["category_name"] != $product['category'])
                                        <option value={{$category["category_name"]}}>{{$category["category_name"]}}
                                        </option>
                                        @endif
                                        @endforeach
                                      </select>
                                      @else
                                      <select id="category{{$product['id']}}" class="select2 form-control">
                                        <option selected disabled>Category</option>
                                        <option value="CATEGORIES">"NO CATEGORIES"</option>
                                      </select>
                                      @endif
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="flavor{{$product['id']}}">Flavor</label>
                                      @if($flavors != null || !empty($flavors))
                                      <select name="flavor" id="flavor{{$product['id']}}" class="select2 form-control"
                                        onchange="checkFlavorName(this)">
                                        <option selected value="{{$product['flavor']}}">{{$product['flavor']}}</option>
                                        @foreach($flavors as $flavor)
                                        @if($flavor["flavor_name"] != $product['flavor'])
                                        <option value={{$flavor["flavor_name"]}}>{{$flavor["flavor_name"]}}</option>
                                        @endif
                                        @endforeach
                                      </select>
                                      @else
                                      <select id="flavor{{$product['id']}}" class="select2 form-control">
                                        <option selected disabled>Flavor</option>
                                        <option value="Flavors">"NO FlAVORS"</option>
                                      </select>
                                      @endif
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="pkgName{{$product['id']}}">Package Name</label>
                                      @if($packages != null || !empty($packages))
                                      <select name="pkgName" id="pkgName{{$product['id']}}" class="select2 form-control"
                                        onchange="checkPkgName(this)">
                                        @foreach($packages as $pkg)
                                        @if($pkg["pkg_name"] == $product['pkg_name'])
                                        <option selected
                                          value='{"pkg_id": "{{$pkg["id"]}}", "pkg_name" : "{{$product["pkg_name"]}}"}'>
                                          {{$product['pkg_name'] . " - "
                                          . $pkg["size"]}}
                                        </option>
                                        @else
                                        <option id={{$pkg["id"]}}
                                          value='{"pkg_id": "{{$pkg["id"]}}", "pkg_name" : "{{$pkg["pkg_name"]}}"}'>
                                          {{$pkg["pkg_name"] . " - " . $pkg["size"]}}
                                        </option>
                                        @endif
                                        @endforeach
                                      </select>
                                      @else
                                      <select class="select2 form-control">
                                        <option selected disabled>Package Names</option>
                                        <option value="Package Name">"NO PACKAGES"</option>
                                      </select>
                                      @endif
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="tax{{$product['id']}}">Advance Income Tax(%)</label>
                                      <input type="text" id="tax{{$product['id']}}" class="form-control"
                                        value="{{$product['advance_income_tax']}}" name="advance_income_tax"
                                        onkeyup="checkAdvanceIncomeTax(this)"
                                        onfocusout="checkInputField(this, {{$product['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="unitPrice{{$product['id']}}">Unit Price</label>
                                      <input type="text" id="unitPrice{{$product['id']}}" class="form-control"
                                        value="{{$product['unit_price']}}" name="unit_price"
                                        onkeyup="checkUnitPrice(this)"
                                        onfocusout="checkInputField(this, {{$product['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-12 d-flex justify-content-end">
                                    <button onclick="submitProductForm({{$product['id']}})" type="submit"
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

                  {{-- delete product modal --}}
                  <div class="modal fade text-left" id="delete-<?php echo $product['id']; ?>" tabindex="-1"
                    role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header bg-danger">
                          <h5 class="modal-title white" id="myModalLabel120">Confirm</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                          </button>
                        </div>
                        <div class="modal-body text-center">
                          <form class="form" action="{{URL('dists/admin/delete/product/'.$product['id'])}}"
                            method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                    </p>
                                    <input name="package_delete" type="hidden" id="package-name" class="form-control"
                                      value="{{$product['id']}}">
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
                </tr>
                @endforeach
                @endif
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Add product Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="productForm{{-1}}" class="form" action="/dists/admin/add/product" method="POST">
            @csrf
            <div class="form-body">
              <div class="row">
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="code{{-1}}">Product Code</label>
                    <input type="text" id="code{{-1}}" class="form-control" placeholder="Product Code"
                      name="product_code" onkeyup="checkProductCode(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="name{{-1}}">Product Name</label>
                    <input type="text" id="name{{-1}}" class="form-control" placeholder="Product Name"
                      name="product_name" onkeyup="checkProductName(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="category{{-1}}">Category</label>
                    @if($categories != null || !empty($categories))
                    <select name="category" id="category{{-1}}" class="select2 form-control"
                      onchange="checkCategoryName(this)">
                      <option selected disabled>Category</option>
                      @foreach($categories as $category)
                      <option value={{$category["category_name"]}}>{{$category["category_name"]}}</option>
                      @endforeach
                    </select>
                    @else
                    <select id="category{{-1}}" class="select2 form-control">
                      <option selected disabled>Category</option>
                      <option value="CATEGORIES">"NO CATEGORIES"</option>
                    </select>
                    @endif
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="flavor{{-1}}">Flavor</label>
                    @if($flavors != null || !empty($flavors))
                    <select name="flavor" id="flavor{{-1}}" class="select2 form-control"
                      onchange="checkFlavorName(this)">
                      <option selected disabled>Flavor</option>
                      @foreach($flavors as $flavor)
                      <option value="{{$flavor['flavor_name']}}">{{$flavor["flavor_name"]}}</option>
                      @endforeach
                    </select>
                    @else
                    <select id="flavor{{-1}}" class="select2 form-control">
                      <option selected disabled>Flavor</option>
                      <option value="Flavors">"NO FlAVORS"</option>
                    </select>
                    @endif
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="pkgName{{-1}}">Package Name</label>
                    @if($packages != null || !empty($packages))
                    <select name="pkgName" id="pkgName{{-1}}" class="select2 form-control"
                      onchange="checkPkgName(this)">
                      <option selected disabled>Package Names</option>
                      @foreach($packages as $pkg)
                      <option id={{$pkg["id"]}}
                        value='{"pkg_id": "{{$pkg["id"]}}", "pkg_name" : "{{$pkg["pkg_name"]}}"}'>{{$pkg["pkg_name"] . "
                        - " . $pkg["size"]}}
                      </option>
                      @endforeach
                    </select>
                    @else
                    <select class="select2 form-control">
                      <option selected disabled>Package Names</option>
                      <option value="Package Name">"NO PACKAGES"</option>
                    </select>
                    @endif
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="tax{{-1}}">Advance Income Tax(%)</label>
                    <input type="text" id="tax{{-1}}" class="form-control" placeholder="Advance Income Tax"
                      name="advance_income_tax" onkeyup="checkAdvanceIncomeTax(this)"
                      onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-12 col-12">
                  <div class="form-group form-field">
                    <label for="unitPrice{{-1}}">Unit Price</label>
                    <input type="text" id="unitPrice{{-1}}" class="form-control" placeholder="Unit Price"
                      name="unit_price" onkeyup="checkUnitPrice(this)" onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitProductForm({{-1}})" type="submit" class="btn btn-success mr-1">Add
                    Product</button>
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
<script src="{{asset('js/addEditProduct.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "name" + id:
        checkProductName(element);
        break;
      case "code" + id:
        checkProductCode(element);
        break;
      // case "category" + id:
      //   checkCategoryName(element);
      //   break;
      // case "flavor" + id:
      //   checkFlavorName(element);
      //   break;
      // case "pkgName" + id:
      //   checkPkgName(element);
      //   break;
      case "unitPrice" + id:
        checkUnitPrice(element);
        break;
      case "tax" + id:
        checkAdvanceIncomeTax(element);
        break;
    }
  }
</script>


@endsection