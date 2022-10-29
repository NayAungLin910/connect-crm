@extends('layout.master')
@section('title', "Create Organization - Connect CRM")
@section('description', "Create a new organization of the Connect Customer Relationship Management")
@section('keywords', "Create Organization Connect CRM Customer Relationship Management")
@section('content')
    <div class="row mt-4">
        <div class="col-sm-5">
            <h4>Create a New Organization</h4>
            <form class="mt-4" action="{{ url('/org/create') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Enter Name</label>
                    <div class="d-flex flex-row align-items-center">
                        <div>
                            <input type="text" name="name" class="form-control my-2" id="exampleInputName">
                        </div>
                        <div class="ms-3">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle"></i>
                                Create
                            </button>
                        </div>
                    </div>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </form>
        </div>
        <div class="col-sm-4"></div>
    </div>
@endsection
