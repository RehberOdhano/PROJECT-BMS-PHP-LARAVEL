@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Profile')
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/swiper.min.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
@endsection
{{-- page-styles --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-user-profile.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/login.css')}}">
@endsection

@section('content')
<!-- page user profile start -->
<section class="page-user-profile">
  @if(session('update'))
  <div class="alert alert-primary">
    {{Session::pull('update')}}
  </div>
  @endif
  <div class="row">
    <div class="col-12">
      <!-- user profile heading section start -->

      <!-- user profile heading section ends -->

      <!-- user profile content section start -->
      <div class="row">
        @foreach ($details as $detail)
        <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
          <!-- user profile nav tabs profile start -->
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="row">
                    <div class="col-12 col-sm-3 text-center mb-1 mb-sm-0 profile-col">
                      <div class="card">
                        @if ($detail["profile"] == "" || $detail["profile"] == null)
                        <img id="profile-image" src='{{asset("/images/profile_bg.jpg")}}' alt="profile image">
                        @else
                        <img id="profile-image" src="{{asset('/images/'.$detail['profile'])}}" alt="profile image">
                        @endif
                      </div>
                    </div>
                    <div class="col-12 col-sm-9">
                      <div class="row">
                        <div style="margin-top: 20px; margin-left: 20px;" class="col-12 text-center text-sm-left">
                          <h2 style="font-size: 20px;" class="mr-50 media-heading mb-0 badge badge-secondary">
                            {{$detail["name"]}}</h2>
                          {{-- <span><i class="fa-solid fa-circle-check"></i></span> --}}
                        </div>
                        <div class="col-12 text-center text-sm-left">
                          <br>
                          <p style="margin-left: 20px;"><i class="fa-solid fa-user mr-50"></i>{{$detail["bio"]}}</p>
                          <div style="margin-left: 20px;">
                            <ul class="list-unstyled">
                              <li><i class="fa-solid fa-location-dot mb-1 mr-50"></i>{{$detail["city"]}}</li>
                              <li><i class="fa-solid fa-phone mb-1 mr-50"></i></i>{{$detail["phone_number"]}}</li>
                              <li><i class="fa-solid fa-envelope mb-1 mr-50"></i>{{$detail["email"]}}</li>
                            </ul>
                          </div>
                          <button class="btn btn-sm d-none d-sm-block float-right btn-light-primary"
                            href="/dists/admin/edit/profile/{{$detail['id']}}"
                            data-target="#edit-admin-<?php echo $detail['id']; ?>" data-toggle="modal">
                            <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i> Edit
                          </button>
                        </div>
                      </div>
                    </div>

                    {{-- Edit Admin Modal --}}
                    <div class="modal-success mr-1 mb-1 d-inline-block">
                      <!--Success theme Modal -->
                      <div class="modal fade text-left" id="edit-admin-<?php echo $detail['id']; ?>" tabindex="-1"
                        role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                          <div class="modal-content">
                            <div class="modal-header bg-success">
                              <h5 class="modal-title white" id="myModalLabel110">Edit Admin</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="bx bx-x"></i>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form id="profileForm" enctype="multipart/form-data" class="form" method="POST"
                                action="{{URL('/dists/admin/edit/profile/'.$detail['id'])}}">
                                @csrf
                                <div class="form-body">
                                  <div class="row">
                                    <div class="col-md-12 col-12">
                                      <div class="form-group form-field">
                                        <label for="name">Full Name</label>
                                        <input type="text" id="name" class="form-control" value="{{$detail['name']}}"
                                          name="name" onkeyup="checkName(this)" onfocusout="checkInputField(this)">
                                        <small></small>
                                      </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                      <div class="form-group form-field">
                                        <label for="bio">Bio</label>
                                        <input type="text" id="bio" class="form-control" value="{{$detail['bio']}}"
                                          name="bio" onkeyup="checkBio(this)" onfocusout="checkInputField(this)">
                                        <small></small>
                                      </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                      <div class="form-group form-field">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" class="form-control" value={{$detail["email"]}}
                                          name="email" onkeyup="checkEmail(this)" onfocusout="checkInputField(this)">
                                        <small></small>
                                      </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                      <div class="form-group form-field">
                                        <label for="city">City</label>
                                        <input type="text" id="city" class="form-control" value="{{$detail['city']}}"
                                          name="city" onkeyup="checkCity(this)" onfocusout="checkInputField(this)">
                                        <small></small>
                                      </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                      <div class="form-group form-field ">
                                        <label for="contact">Contact</label>
                                        <input type="text" id="contact" class="form-control"
                                          value={{$detail["phone_number"]}} name="contact" onkeyup="checkContact(this)"
                                          onfocusout="checkInputField(this)">
                                        <small></small>
                                      </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                      <div class="form-group form-field">
                                        <label for="file">Profile Picture</label>
                                        <input type='file' name='profile' onkeyup="checkFile(this)"
                                          onfocusout="checkInputField(this)" id='file' class='form-control'>
                                        <small></small>
                                      </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                      <button onclick="submitProfileForm()" type="submit"
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

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- user profile nav tabs profile ends -->
        </div>
        @endforeach


        <!-- user profile right side content ends -->
      </div>
      <!-- user profile content section start -->
    </div>
  </div>
</section>
<!-- page user profile ends -->
@endsection

{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="{{asset('vendors/js/extensions/swiper.min.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/pages/page-user-profile.js')}}"></script>
<script src="{{asset('js/editAdminProfile.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
  const checkInputField = (element) => {
    switch(element.id) {
      case "name":
        checkName(element);
        break;
      case "email":
        checkEmail(element);
        break;
      case "city":
        checkCity(element);
        break;
      case "bio":
        checkBio(element);
        break;
      case "contact":
        checkContact(element);
        break;
      case "file":
        checkFile(element);
        break;
    }
  }
</script>
@endsection