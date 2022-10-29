@extends('layout.master')
@section('title', 'Create Activity - Connect CRM')
@section('description', 'Creating a new activity of the Connect Customer Relationship Management')
@section('keywords', 'Creating Activity Connect CRM Customer Relationship Management')
@section('content')
    <div class="row mt-4">
        <div class="col-sm-5">
            <h5 class="text-center">Create a New Activity to Do with {{ $lead->name }}</h5>
            <form class="mt-4" action="{{ url('/activity/create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input name="lead_id" type="hidden" value="{{ $lead->id }}">
                <div class="form-group">
                    <label for="exampleInputName">Enter Name</label>
                    <input type="text" name="name" class="form-control my-2" id="exampleInputName">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputDescription">Enter Description</label>
                    <textarea name="description" class="form-control my-2" id="exampleInputDescription"></textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="type-select">Choose Type</label>
                    <div class="my-2">
                        <select name="type" class="form-select my-2" id="type-select">
                            <option value="meeting">Meeting</option>
                            <option value="call">Call</option>
                            <option value="vc">VC</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    @if ($errors->has('type'))
                        <span class="text-danger">{{ $errors->first('type') }}</span>
                    @endif
                </div>
                <div class="form-group mt-2">
                    <label for="formFile" class="form-label">Choose File for the Activity</label>
                    <input name="file" class="form-control my-1" type="file" id="formFile">
                    @if ($errors->has('file'))
                        <span class="text-danger">{{ $errors->first('file') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="start-date-iput">Choose Start Date</label>
                    <input type="datetime-local" name="start_date" id="start-date-input" class="form-control my-2">
                    @if ($errors->has('start_date'))
                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="end-date-iput">Choose End Date</label>
                    <input type="datetime-local" name="end_date" id="end-date-input" class="form-control my-2">
                    @if ($errors->has('end_date'))
                        <span class="text-danger">{{ $errors->first('end_date') }}</span>
                    @endif
                </div>
                <div class="d-flex justify-content-evenly align-items-center mt-4 mb-2">
                    <div>
                        <a href="{{ url('/lead/edit/' . $lead->slug) }}" class="btn btn-dark">
                            <i class="bi bi-arrow-left"></i>
                            Back
                        </a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i>
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-4"></div>
    </div>
@endsection
