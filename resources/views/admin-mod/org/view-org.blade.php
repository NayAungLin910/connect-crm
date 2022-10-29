@extends('layout.master')
@section('title', 'Organizations - Connect CRM')
@section('description', 'Organizations of the Connect Customer Relationship Management')
@section('keywords', 'Organizations Connect CRM Customer Relationship Management')
@section('css')
    @viteReactRefresh
@endsection
@section('content')
    <div id="root"></div>
    @vite('resources/js/viewOrg.jsx')
@endsection
