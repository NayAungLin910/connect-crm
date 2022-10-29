@extends('layout.master')
@section('title', 'Leads - Connect CRM')
@section('description', 'Leads of the Connect Customer Relationship Management')
@section('keywords', 'Leads Connect CRM Customer Relationship Management')
@section('css')
    @viteReactRefresh
@endsection
@section('content')
    <div id="root"></div>
    @vite('resources/js/viewLead.jsx')
@endsection
@section('script')
    <script>
        window.by = "{{ $by }}"
        window.contact_slug = "{{ $contact_slug }}"
        window.business_slug = "{{ $business_slug }}"
        window.source_slug = "{{ $source_slug }}"
    </script>
@endsection
