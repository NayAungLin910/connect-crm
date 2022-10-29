@extends('layout.master')
@section('title', "Edit User $user->name Profile - Connect CRM")
@section('description', "Edit the profile of the user $user->name, of the Connect Customer Relationship Management")
@section('keywords', "Edit $user->name Profile Connect CRM Customer Relationship Management")
@section('content')
    <div class="row mt-4">
        <div class="col-sm-4">
            <div class="text-center">
                <img class="rounded-circle" width="100" height="100" src="{{ '/storage/images/' . $user->image }}"
                    alt="{{ $user->name }}">
            </div>
            <form action="{{ url('/edit-profile') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="form-group my-2">
                    <label for="inputName">Name</label>
                    <input name="name" type="text" value="{{ $user->name }}" class="form-control" id="inputName"
                        placeholder="Enter Name">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group my-2">
                    <label for="inputEmail">Email</label>
                    <input name="email" type="email" value="{{ $user->email }}" class="form-control" id="inputEmail"
                        placeholder="Enter Email">
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group my-2">
                    <label for="formFile" class="form-label">Choose a New Profile Image</label>
                    <input name="image" class="form-control" type="file" id="formFile">
                    @if ($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                </div>
                <div class="d-flex mt-4 justify-content-around align-items-center">
                    <a href="{{ url('/profile') }}" type="submit" class="btn btn-sm btn-dark">
                        <i class="bi bi-chevron-left mx-1"></i>
                        Back
                    </a>
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="bi bi-check2 mx-1"></i>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
