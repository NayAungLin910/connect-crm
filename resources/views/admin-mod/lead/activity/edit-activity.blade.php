@extends('layout.master')
@section('title', "Edit Activity - $activity->name - Connect CRM")
@section('description', "Edit the activity, $activity->name of the Connect Customer Relationship Management")
@section('keywords', "Edit Activity $activity->name Connect CRM Customer Relationship Management")
@section('content')
    <div class="row mt-4">
        <div class="col-sm-6">
            <h5 class="text-center">Edit the Activity, {{ $activity->name }}</h5>
            <form class="mt-4" action="{{ url('/activity/edit/' . $activity->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Enter Name</label>
                    <input value="{{ $activity->name }}" type="text" name="name" class="form-control my-2"
                        id="exampleInputName">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputDescription">Enter Description</label>
                    <textarea name="description" class="form-control my-2" id="exampleInputDescription">{{ $activity->description }}
                    </textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="type-select">Choose Type</label>
                    <div class="my-2">
                        <select name="type" class="form-select my-2" id="type-select">
                            <option @if ($activity->type == 'meeting') selected @endif value="meeting">Meeting</option>
                            <option @if ($activity->type == 'call') selected @endif value="call">Call</option>
                            <option @if ($activity->type == 'vc') selected @endif value="vc">VC</option>
                            <option @if ($activity->type == 'other') selected @endif value="other">Other</option>
                        </select>
                    </div>
                    @if ($errors->has('type'))
                        <span class="text-danger">{{ $errors->first('type') }}</span>
                    @endif
                </div>
                <div class="form-group my-2">
                    <p class="mb-2">Old File</p>
                    <a class="btn btn-sm btn-primary" href="{{ url('/storage/files/' . $activity->file) }}">
                        <i class="bi bi-download mx-2"></i>
                        {{ $activity->file_name }}
                    </a>
                </div>
                <div class="form-group mt-2">
                    <label for="formFile" class="form-label">Choose a New File for the Activity</label>
                    <input name="file" class="form-control my-1" type="file" id="formFile">
                    @if ($errors->has('file'))
                        <span class="text-danger">{{ $errors->first('file') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="start-date-iput">Choose Start Date</label>
                    <input value="{{ $activity->start_date }}" type="datetime-local" name="start_date" id="start-date-input" class="form-control my-2">
                    @if ($errors->has('start_date'))
                        <span class="text-danger">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="end-date-iput">Choose End Date</label>
                    <input value="{{ $activity->end_date }}" type="datetime-local" name="end_date" id="end-date-input" class="form-control my-2">
                    @if ($errors->has('end_date'))
                        <span class="text-danger">{{ $errors->first('end_date') }}</span>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                    <div>
                        <a href="{{ url('/activity/view') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i>
                            View Activities
                        </a>
                    </div>
                    <div>
                        <a href="{{ url('/lead/edit/' . $activity->lead->slug) }}" class="btn btn-sm btn-dark">
                            <i class="bi bi-pencil-square"></i>
                            Edit the Lead, {{ $activity->lead->name }}
                        </a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="bi bi-check2"></i>
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
