@extends('layouts.fullLayoutMaster')

@section('title','Reset Password')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/login.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@section('content')
<section class="row flexbox-container">
  <div class="col-xl-7 col-10">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <!-- left section-login -->
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right d-flex justify-content-center mb-0 p-2 h-100">
            <div class="card-header pb-1">
              <div class="card-title">
                <h4 class="text-center mb-2">Reset your Password</h4>
              </div>
            </div>
            <div class="ml-3 ml-md-2 mr-1 text-center">
              @if(session('error'))
                <div class="alert alert-danger">
                  {{Session::pull('error')}}
                </div>
              @endif
            </div>
            <div class="card-body">
              {{-- <form id="resetPasswordForm" class="mb-2 my-login-validation" nonvalidate="" method="POST" action="{{url('/reset/password')}}"> --}}
              <form id="resetPasswordForm" class="mb-2 my-login-validation" nonvalidate="" method="POST" action="/reset-password">
                @csrf
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                  <label class="text-bold-600" for="email">Email</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid 
                  @enderror" name="email" value="{{ $email ?? old('email') }}"  autocomplete="email" 
                  autofocus onkeyup="checkEmail(this)" onfocusout="checkInputField(this)">
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                  <small></small>
                </div>

                <div class="form-group">
                  <label class="text-bold-600" for="password">New Password</label>
                  <input id="password" type="password" class="form-control @error('password') 
                  is-invalid @enderror" name="password"  autocomplete="new-password"
                  onkeyup="checkPassword(this)" onfocusout="checkInputField(this)">

                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                  <small></small>
                </div>

                <div class="form-group mb-2">
                  <label class="text-bold-600" for="password-confirm">Confirm New Password</label>
                  <input id="password-confirm" type="password" class="form-control" 
                  name="password_confirmation"  autocomplete="new-password"
                  onkeyup="checkConfirmPassword(this)" onfocusout="checkInputField(this)">
                  <small></small>
                </div>

                <button onclick="submitResetPassForm()" type="submit" class="btn btn-primary glow position-relative w-100">
                    Reset my password
                  <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
        <!-- right section image -->
        <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
          <img class="img-fluid" src="{{asset('images/pages/reset-password.png')}}" alt="branding logo">
        </div>
      </div>
    </div>
  </div>
</section>

<script src="{{asset('/js/resetPassword.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
</script>
@endsection
