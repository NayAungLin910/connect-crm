@extends('layout.master-auth')
@section('title', "Admin Login - Connect CRM")
@section('description', "Admin login page of the Connect Customer Relationship Management")
@section('keywords', "Admin Login Connect CRM Customer Relationship Management")
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="card text-white mb-4" style="background-color: #212529">
                <div class="card-header">
                    <h4 class="text-center">Admin Login</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('/login-admin') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="InputEmail1">Email</label>
                            <input name="email" type="email" class="form-control" id="InputEmail1">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="InputPassword">Password</label>
                            <input name="password" type="password" class="form-control" id="InputPassword">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-check mt-2">
                            <input name="remember" class="form-check-input" type="checkbox" value="remember"
                                id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Remember me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
@endsection
