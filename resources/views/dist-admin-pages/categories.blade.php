@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Categories')

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
  integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<!-- Knowledge base Jumbotron start -->
<section id="breadcrumb-rounded-divider" class="mb-2">
  <div class="row">
    <div class="col-12">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded-pill breadcrumb-divider">
          <li class="breadcrumb-item"><a href="/dists/admin/dashboard"><i class="bx bx-home"></i></a></li>
          <li class="breadcrumb-item active" aria-current="page">Categories</li>
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
  @elseif(session('error'))
  <div class="alert alert-danger">
    {{Session::pull('error')}}
  </div>
  @endif
</section>
<section class="kb-search">
  <div class="row">
    <div class="col d-flex justify-content-between">
      <h2>Categories</h2>
      <button type="button" class="btn btn-success glow mr-1 mb-1" data-toggle="modal" data-target="#add"><i
          class="bx bx-plus"></i>
        <span class="align-middle ml-25">Add Category</span></button>
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
                  <th>Category Name</th>
                  <th>Added On</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($details as $detail)
                <tr>
                  <td>{{$detail["category_name"]}}</td>
                  <td>{{date('d-m-Y', strtotime(substr($detail["created_at"], 0, 10)))}}</td>
                  <td class="text-center py-1">
                    <div class="dropup">
                      <span
                        class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                      </span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="" data-target="#edit-category-<?php echo $detail['id']; ?>"
                          data-toggle="modal"><i class="bx bx-edit-alt mr-1"></i> edit</a>
                        <a class="dropdown-item" id="confirm-text" href=""
                          data-target="#delete-<?php echo $detail['id']; ?>" data-toggle="modal"><i
                            class="bx bx-trash mr-1"></i> delete</a>
                      </div>
                    </div>
                  </td>

                  {{-- Edit Category Modal --}}
                  <div class="modal-success mr-1 mb-1 d-inline-block">
                    <!--Success theme Modal -->
                    <div class="modal fade text-left" id="edit-category-<?php echo $detail['id']; ?>" tabindex="-1"
                      role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                      <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <h5 class="modal-title white" id="myModalLabel110">Edit Stock</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <i class="bx bx-x"></i>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="categoryForm{{$detail['id']}}" class="form" method="POST"
                              action="{{URL('/dists/admin/edit/category/'.$detail['id'])}}">
                              @csrf
                              <div class="form-body">
                                <div class="row">
                                  <div class="col-md-12 col-12">
                                    <div class="form-group form-field">
                                      <label for="name{{$detail['id']}}">Category Name</label>
                                      <input type="text" id="name{{$detail['id']}}" class="form-control"
                                        value="{{$detail['category_name']}}" name="category_name"
                                        onkeyup="checkCategoryName(this)"
                                        onfocusout="checkInputField(this, {{$detail['id']}})">
                                      <small></small>
                                    </div>
                                  </div>
                                  <div class="col-12 d-flex justify-content-end">
                                    <button onclick="submitCategoryForm({{$detail['id']}})" type="submit"
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

                  {{-- Delete Category Modal --}}
                  <div class="modal fade text-left" id="delete-<?php echo $detail['id']; ?>" tabindex="-1" role="dialog"
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
                          <form class="form" action="{{URL('/dists/admin/delete/category/'.$detail['id'])}}"
                            method="POST">
                            @csrf
                            <div class="form-body">
                              <div class="row">
                                <div class="col-md-12 col-12">
                                  <div class="form-label-group">
                                    <p style="font-size: 20px; font-weight: bold">If you delete this category, then the
                                      related products will also be deleted.
                                    </p>
                                    <p style="font-size: 20px; font-weight: bold">Are you sure you want to delete this?
                                    </p>
                                    <input name="delete_dist" type="hidden" id="delete_dist" class="form-control"
                                      value="{{$detail['id']}}">
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
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Add Category Modal --}}
<div class="modal-success mr-1 mb-1 d-inline-block">
  <!--Success theme Modal -->
  <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title white" id="myModalLabel110">Add Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="categoryForm{{-1}}" class="form" method="POST" action="{{URL('/dists/admin/add/category')}}">
            @csrf
            <div class="form-body" id="add-category-row">
              <div class="row">
                <div class="col-md-8 col-8">
                  <div class="form-group form-field">
                    <label for="name{{-1}}">Enter Categories</label>
                    <input type="text" id="name{{-1}}" class="form-control" placeholder="Category Name"
                      name="category_names[]" onkeyup="checkCategoryName(this)"
                      onfocusout="checkInputField(this, {{-1}})">
                    <small></small>
                  </div>
                </div>
                <div class="col-md-4 col-4" style="margin-top: 22px;">
                  <div class="form-group form-field">
                    <button style="font-size: 16px;" onclick="add_row();" type="button" class="btn btn-success"><i
                        class="fa-solid fa-plus"></i></button>
                    <button disabled style="font-size: 16px;" onclick="delete_row(this);" type="button"
                      class="btn btn-primary"><i class="fa-solid fa-xmark"></i></button>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 d-flex justify-content-end">
                  <button onclick="submitCategoryForm({{-1}})" type="submit" class="btn btn-success mr-1">Add
                    Category</button>
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
<script src="{{asset('js/addEditCategory.js')}}"></script>
<script>
  function add_row() {
    var id = Math.floor(Math.random() * 10001);
    var parentElement = document.getElementById("add-category-row");
    const length = parentElement.childNodes.length - 3;
    const lastChild = parentElement.childNodes[length];

    var parentDiv = document.createElement("div");
    var childDiv1 = document.createElement("div");
    var childDiv2 = document.createElement("div");
    var childDiv3 = document.createElement("div");
    var childDiv4 = document.createElement("div");

    var input = document.createElement("input");  
    var addBTN = document.createElement("span");
    var delBTN = document.createElement("span");
    var small = document.createElement("small");	
    
    parentDiv.className = "row";
    parentDiv.id = id;
    childDiv1.className = "col-md-8 col-8";
    childDiv2.className = "form-group form-field";
    childDiv3.className = "col-md-4 col-4";
    childDiv4.className = "form-group form-field";	

    input.type = "text";
    input.id = `name${id}`;
    input.className = "form-control";
    input.name = "category_names[]";
    input.placeholder = "Category Name";
    input.setAttribute("onkeyup", "checkCategoryName(this)");
    input.setAttribute("onfocusout", `checkInputField(this, ${id})`);
    
    addBTN.style = "font-size: 16px; margin-right: 5px;";
    addBTN.innerHTML = `<button type="button" class="btn btn-success" onclick="add_row()"><i class="fa-solid fa-plus"></i></button>`
    
    delBTN.style = "font-size: 16px; margin-right: 5px;";
    delBTN.innerHTML = `<button type="button" class="btn btn-primary" onclick="delete_row(this)"><i class="fa-solid fa-xmark"></i></button>`

    childDiv2.appendChild(input);
    childDiv2.appendChild(small);
    childDiv1.appendChild(childDiv2);

    childDiv4.appendChild(addBTN);
    childDiv4.appendChild(delBTN);
    childDiv3.appendChild(childDiv4);

    parentDiv.appendChild(childDiv1);
    parentDiv.appendChild(childDiv3);
    parentElement.insertBefore(parentDiv, lastChild);
  }

  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element, id) => {
    switch(element.id) {
      case "name" + id:
        checkCategoryName(element);
        break;
    }
  }
</script>


@endsection