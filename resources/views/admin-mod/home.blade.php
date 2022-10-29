@extends('layout.master')
@section('title', 'Home - Connect CRM')
@section('description', 'Homepage of the Connect Customer Relationship Management')
@section('keywords', 'Homepage Connect CRM Customer Relationship Management')
@section('css')
    @viteReactRefresh
@endsection
@section('content')
    <div id="root"></div>
    @vite('resources/js/home.jsx')
@endsection