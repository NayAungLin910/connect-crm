@extends('layout.master')
@section('title', 'Contacts - Connect CRM')
@section('description', 'Contacts of the Connect Customer Relationship Management')
@section('keywords', 'Contacts Connect CRM Customer Relationship Management')
@section('css')
    @viteReactRefresh
@endsection
@section('content')
    <div id="root"></div>
    @vite('resources/js/viewContact.jsx')
@endsection
@section('script')
    <script>
        window.org_slug = "{{ $org_slug }}"
    </script>
@endsection
