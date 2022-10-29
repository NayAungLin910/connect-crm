@extends('layout.master')
@section('title', 'Edit Lead - Connect CRM')
@section('description', 'Edit a lead of the Connect Customer Relationship Management')
@section('keywords', 'Edit Lead Connect CRM Customer Relationship Management')
@section('css')
    @viteReactRefresh
@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-sm-5">
            <h4 class="text-center">{{ $lead->name }}</h4>
            <form class="mt-4" action="{{ url('/lead/edit/' . $lead->slug) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Enter Name</label>
                    <input value="{{ $lead->name }}" type="text" name="name" class="form-control my-2"
                        id="exampleInputName">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputDescription">Enter Description</label>
                    <textarea name="description" class="form-control my-2" id="exampleInputDescription">{{ $lead->description }}</textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputValue">Enter Value</label>
                    <input value="{{ $lead->value }}" type="text" name="value" class="form-control my-2"
                        id="exampleInputValue">
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
                                <option value="{{ $s->id }}" @if ($lead->source_id == $s->id) selected @endif>
                                    {{ $s->name }}</option>
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
                            <option @if ($lead->progress == 'new') selected @endif value="new">New</option>
                            <option @if ($lead->progress == 'follow up') selected @endif value="follow up">Follow Up</option>
                            <option @if ($lead->progress == 'prospect') selected @endif value="prospect">Prospect</option>
                            <option @if ($lead->progress == 'negotiation') selected @endif value="negotiation">Negotiation
                            </option>
                            <option @if ($lead->progress == 'won') selected @endif value="won">Won</option>
                            <option @if ($lead->progress == 'lost') selected @endif value="lost">Lost</option>
                        </select>
                    </div>
                    @if ($errors->has('progress'))
                        <span class="text-danger">{{ $errors->first('progress') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="close-date-iput">Choose Close Date</label>
                    <input value="{{ $lead->close_date }}" type="datetime-local" name="close_date" id="close-date-input"
                        class="form-control my-2">
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
                                <option value="{{ $c->id }}" @if ($lead->contact_id == $c->id) selected @endif>
                                    {{ $c->name }}</option>
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
                                <option value="{{ $p->id }}" @if ($lead->product_id == $p->id) selected @endif>
                                    {{ $p->name }}</option>
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
                                <option value="{{ $b->id }}" @if ($lead->business_id == $b->id) selected @endif>
                                    {{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('business_id'))
                        <span class="text-danger">{{ $errors->first('business_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputQuantity">Enter Quantity</label>
                    <input value="{{ $lead->quantity }}" type="text" name="quantity" class="form-control my-2"
                        id="exampleInputQuantity">
                    @if ($errors->has('quantity'))
                        <span class="text-danger">{{ $errors->first('quantity') }}</span>
                    @endif
                </div>
                <div class="d-flex justify-content-evenly align-items-center my-3">
                    <div>
                        <a href="{{ url('/lead/view') }}" class="btn btn-dark">
                            <i class="bi bi-arrow-left"></i>
                            Back
                        </a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check"></i>
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            <h5 class="text-center">Activities to Do with {{ $lead->name }}</h5>
            <a href="{{ '/activity/create/' . $lead->slug }}" class="btn btn-sm btn-primary  my-3">
                <i class="bi bi-plus-circle"></i>
                Create Activity
            </a>
            <div id="root"></div>
            @vite('resources/js/viewActivity.jsx')
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.lead = @json($lead)
    </script>
@endsection
