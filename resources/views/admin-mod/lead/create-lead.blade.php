@extends('layout.master')
@section('title', 'Create Lead - Connect CRM')
@section('description', 'Create a new lead of the Connect Customer Relationship Management')
@section('keywords', 'Create Lead Connect CRM Customer Relationship Management')
@section('content')
    <div class="row mt-4">
        <div class="col-sm-5">
            <h4 class="text-center">Create a New Lead</h4>
            <form class="mt-4" action="{{ url('/lead/create') }}" method="POST">
                @csrf
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
                    <label for="exampleInputValue">Enter Value</label>
                    <input type="text" name="value" class="form-control my-2" id="exampleInputValue">
                    @if ($errors->has('value'))
                        <span class="text-danger">{{ $errors->first('value') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="source-select">Choose Source</label>
                    <div class="my-2">
                        <select name="source_id" class="form-select select2 my-2" aria-label="source select"
                            id="source-select">
                            @foreach ($sources as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('source_id'))
                        <span class="text-danger">{{ $errors->first('source_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="progress-select">Choose Progress</label>
                    <div class="my-2">
                        <select name="progress" class="form-select my-2" id="progress-select">
                            <option value="new">New</option>
                            <option value="follow up">Follow Up</option>
                            <option value="prospect">Prospect</option>
                            <option value="negotiation">Negotiation</option>
                            <option value="won">Won</option>
                            <option value="lost">Lost</option>
                        </select>
                    </div>
                    @if ($errors->has('progress'))
                        <span class="text-danger">{{ $errors->first('progress') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="close-date-iput">Choose Close Date</label>
                    <input type="datetime-local" name="close_date" id="close-date-input" class="form-control my-2">
                    @if ($errors->has('close_date'))
                        <span class="text-danger">{{ $errors->first('close_date') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="contact-select">Choose Contact</label>
                    <div class="my-2">
                        <select name="contact_id" class="form-select select2 my-2" aria-label="contact select"
                            id="contact-select">
                            @foreach ($contacts as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('contact_id'))
                        <span class="text-danger">{{ $errors->first('contact_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="product-select">Choose Product</label>
                    <div class="my-2">
                        <select name="product_id" class="form-select select2 my-2" aria-label="product select"
                            id="product-select">
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('product_id'))
                        <span class="text-danger">{{ $errors->first('product_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="business-select">Choose Business</label>
                    <div class="my-2">
                        <select name="business_id" class="form-select select2 my-2" aria-label="business select"
                            id="business-select">
                            @foreach ($businesses as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('business_id'))
                        <span class="text-danger">{{ $errors->first('business_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputQuantity">Enter Quantity</label>
                    <input type="text" name="quantity" class="form-control my-2" id="exampleInputQuantity">
                    @if ($errors->has('quantity'))
                        <span class="text-danger">{{ $errors->first('quantity') }}</span>
                    @endif
                </div>
                <center>
                    <button type="submit" class="btn btn-sm btn-success text-center my-3">
                        <i class="bi bi-plus-circle"></i>
                        Create
                    </button>
                </center>
            </form>
        </div>
        <div class="col-sm-4"></div>
    </div>
@endsection
