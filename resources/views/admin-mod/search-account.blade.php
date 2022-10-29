@extends('layout.master')
@section('title', 'Search Account - Connect CRM')
@section('description', 'Search Account page of the Connect Customer Relationship Management')
@section('keywords', 'Search Account Connect CRM Customer Relationship Management')
@section('css')
    @viteReactRefresh
@endsection
@section('content')
    <div id="root"></div>
    @vite('resources/js/viewAccount.jsx')
@endsection
