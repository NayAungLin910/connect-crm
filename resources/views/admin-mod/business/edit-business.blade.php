@extends('layout.master')
@section('title', "Edit Business - $business->name - Connect CRM")
@section('description', "Edit the business, $business->name of the Connect Customer Relationship Management")
@section('keywords', "Edit Contact $business->name Connect CRM Customer Relationship Management")
@section('content')
    <div class="row mt-4">
        <div class="col-sm-5">
            <h4>Rename Business</h4>
            <form class="mt-4" action="{{ url('/business/edit/' . $business->slug) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Enter Name</label>
                    <div class="d-flex flex-row align-items-center">
                        <div>
                            <input type="text"
                                value="{{ $errors->has('name') && $errors->first('name') !== 'Please write a new name!' ? old('name') : $business->name }}"
                                name="name" class="form-control my-2" id="exampleInputName" aria-describedby="emailHelp">
                        </div>
                        <div class="ms-3">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check"></i>
                                Save
                            </button>
                        </div>
                        <div class="ms-3">
                            <a href="{{ url('/business/view') }}" class="btn btn-sm btn-dark">
                                <i class="bi bi-arrow-left"></i>
                                Back
                            </a>
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
