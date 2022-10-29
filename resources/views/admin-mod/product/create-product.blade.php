@extends('layout.master')
@section('title', 'Create Product - Connect CRM')
@section('description', 'Create a new product of the Connect Customer Relationship Management')
@section('keywords', 'Create Product Connect CRM Customer Relationship Management')
@section('content')
    <div class="row mt-4">
        <div class="col-sm-5">
            <h4 class="text-center">Create a New Product</h4>
            <form class="mt-4" action="{{ url('/product/create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Enter Name</label>
                    <input type="text" name="name" class="form-control my-2" id="exampleInputName">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputSku">Enter SKU</label>
                    <input type="text" name="sku" class="form-control my-2" id="exampleInputSku">
                    @if ($errors->has('sku'))
                        <span class="text-danger">{{ $errors->first('sku') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputPrice">Enter Price</label>
                    <input type="text" name="price" class="form-control my-2" id="exampleInputPrice">
                    @if ($errors->has('price'))
                        <span class="text-danger">{{ $errors->first('price') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputDescription">Enter Description</label>
                    <textarea name="description" class="form-control my-2" id="exampleInputDescription"></textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="form-group mt-2">
                    <label for="formFile" class="form-label">Upload Image for the Product</label>
                    <input name="image" class="form-control my-1" type="file" id="formFile">
                    @if ($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                </div>
                <center>
                    <button type="submit" class="btn btn-sm btn-success text-center mt-3">
                        <i class="bi bi-plus-circle"></i>
                        Create
                    </button>
                </center>
            </form>
        </div>
    </div>
    <div class="col-sm-4"></div>
    </div>
@endsection
