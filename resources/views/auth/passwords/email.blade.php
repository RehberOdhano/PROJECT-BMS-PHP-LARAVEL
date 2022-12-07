@extends('layouts.fullLayoutMaster')
{{-- page title --}}
@section('title','Forgot Password')
{{-- page scripts --}}
@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/authentication.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/login.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
  integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('content')
<!-- forgot password start -->
<section class="row flexbox-container">
  <div class="col-xl-7 col-md-9 col-10  px-0">
    <div class="card bg-authentication mb-0">
      <div class="row m-0">
        <!-- left section-forgot password -->
        <div class="col-md-6 col-12 px-0">
          <div class="card disable-rounded-right mb-0 p-2">
            <div class="card-header pb-1">
              <div class="card-title">
                <h4 class="text-center mb-2">Forgot Password?</h4>
              </div>
            </div>
            <div class="form-group d-flex justify-content-center align-items-center mb-2">
              <div class="text-left">
                <div class="ml-3 ml-md-2 mr-1">
                  <a href="{{asset('/')}}" class="card-link btn btn-outline-primary text-nowrap">Sign in</a>
                </div>
              </div>
              {{-- <div class="mr-3">
                <a href="{{asset('register')}}" class="card-link btn btn-outline-primary text-nowrap">Sign up</a>
              </div> --}}
            </div>
            <div class="ml-3 ml-md-2 mr-1 text-center">
              @if(session('success'))
              <div class="alert alert-success">
                {{Session::pull('success')}}
              </div>
              @elseif(session('error'))
              <div class="alert alert-danger">
                {{Session::pull('error')}}
              </div>
              @endif
            </div>
            <div class="card-body">
              <div class="text-muted text-center mb-2">
                <small>Enter the email you used when you joined and we will send you a link to reset your
                  password.</small>
              </div>
              {{-- form --}}
              <form id="login" method="POST" action="/forgot-password">
                @csrf
                @if(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
                @elseif(session('status'))
                <div class="alert alert-success">{{session('status')}}</div>
                @endif
                <div class="form-group mb-2">
                  <label class="text-bold-600" for="email">Email</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid 
                  @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Email"
                    onkeyup="checkEmail(this)" onfocusout="checkInputField(this)">
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                  <small></small>
                </div>
                <button type="submit" class="btn btn-primary glow position-relative w-100">SEND PASSWORD
                  <i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
        <!-- right section image -->
        <div class="col-md-6 d-md-block d-none text-center align-self-center">
          <img class="img-fluid" src="{{asset('images/pages/forgot-password.png')}}" alt="branding logo" width="300">
        </div>
      </div>
    </div>
  </div>
</section>
<script src="{{asset('/js/resetPassword.js')}}"></script>
<script>
  $('div.alert').delay(3000).slideUp(300);
</script>
<!-- forgot password ends -->
@endsection