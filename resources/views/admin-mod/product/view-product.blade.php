@extends('layout.master')
@section('title', 'Products - Connect CRM')
@section('description', 'Products of the Connect Customer Relationship Management')
@section('keywords', 'Products Connect CRM Customer Relationship Management')
@section('css')
    @viteReactRefresh
@endsection
@section('content')
    <div id="root"></div>
    @vite('resources/js/viewProduct.jsx')
@endsection