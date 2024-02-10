@extends('admin.layouts.forgot')
@section('content')
<main class="login-form mt-5">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                    <div class="card-header text-center">
                        <img src="{{ asset('assets/img/logo.png') }}"/>
                       <h4 class="mt-3" style="color:black;font-weight:600;"> Reset Password</h4>
                    </div>
                    <div class="card-body">
  
                      <form action="{{ route('reset.password.post') }}" method="POST">
                          @csrf
                          <input type="hidden" name="token" value="{{ $token }}">
  
                          <div class="form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password" required autofocus>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                                  @if ($errors->has('password_confirmation'))
                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="col-md-12 text-center">
                              <button type="submit" class="btn btn-primary">
                                  Reset Password
                              </button>
                          </div>
                            @if(session()->has('message'))
                                <div class="col-md-6 offset-md-4 alert alert-success">
                                    {{ session()->get('message') }}  <a href="{{ route('home') }}">Click Here to Login </a>
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="col-md-6 offset-md-4 alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection
