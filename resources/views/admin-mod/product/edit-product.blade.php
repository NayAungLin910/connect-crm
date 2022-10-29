@extends('layout.master')
@section('title', 'Create Product - Connect CRM')
@section('description', 'Create a new product of the Connect Customer Relationship Management')
@section('keywords', 'Create Product Connect CRM Customer Relationship Management')
@section('content')
    <div class="row mt-4">
        <div class="col-sm-5">
            <center>
                <img src="{{ url('/storage/images/' . $product->image) }}" width="100" height="100" class="rounded-circle"
                    alt="{{ $product->name }}">
            </center>
            <h4 class="text-center mt-3">{{ $product->name }}</h4>
            <form class="mt-4" action="{{ url('/product/edit/' . $product->slug) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Edit Name</label>
                    <input type="text" value="{{ $product->name }}" name="name" class="form-control my-2"
                        id="exampleInputName">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputSku">Edit SKU</label>
                    <input type="text" value="{{ $product->sku }}" name="sku" class="form-control my-2"
                        id="exampleInputSku">
                    @if ($errors->has('sku'))
                        <span class="text-danger">{{ $errors->first('sku') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputPrice">Edit Price</label>
                    <input type="text" value="{{ $product->price }}" name="price" class="form-control my-2"
                        id="exampleInputPrice">
                    @if ($errors->has('price'))
                        <span class="text-danger">{{ $errors->first('price') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputDescription">Edit Description</label>
                    <textarea name="description" class="form-control my-2" id="exampleInputDescription">{{ $product->description }}</textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="form-group mt-2">
                    <label for="formFile" class="form-label">Upload a New Image for the Product</label>
                    <input name="image" class="form-control my-1" type="file" id="formFile">
                    @if ($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                </div>
                <div class="d-flex justify-content-evenly align-items-center mt-4 mb-2">
                    <div>
                        <a href="{{ url('/product/view') }}" class="btn btn-dark">
                            <i class="bi bi-arrow-left"></i>
                            Back
                        </a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success text-center">
                            <i class="bi bi-check"></i>
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-4"></div>
    </div>
@endsection
