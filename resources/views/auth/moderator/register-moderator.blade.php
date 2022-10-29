@extends('layout.master-auth')
@section('title', "Moderator Register - Connect CRM")
@section('description', "Moderator regsiter page of the Connect Customer Relationship Management")
@section('keywords', "Moderator Register Connect CRM Customer Relationship Management")
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <div class="card text-white mb-4" style="background-color: #212529">
                <div class="card-header">
                    <h4 class="text-center">Moderator Register</h4>
                </div>
                <div class="card-body">
                    <form action="{{ url('/register-moderator') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="InputName">Name</label>
                            <input name="name" type="text" class="form-control" id="InputName">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
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
                        <div class="form-group">
                            <label for="formFile" class="form-label">Choose Profile Image</label>
                            <input name="image" class="form-control" type="file" id="formFile">
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="bi bi-card-checklist"></i>
                            Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
@endsection
