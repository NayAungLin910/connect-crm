@extends('layout.master')
@section('title', 'Businesses - Connect CRM')
@section('description', 'Businesses of the Connect Customer Relationship Management')
@section('keywords', 'Businesses Connect CRM Customer Relationship Management')
@section('css')
    @viteReactRefresh
@endsection
@section('content')
    <div id="root"></div>
    @vite('resources/js/viewBusiness.jsx')
@endsection
