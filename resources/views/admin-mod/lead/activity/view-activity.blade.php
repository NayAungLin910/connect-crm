@extends('layout.master')
@section('title', 'Activities - Connect CRM')
@section('description', 'Activities of the Connect Customer Relationship Management')
@section('keywords', 'Activities Connect CRM Customer Relationship Management')
@section('css')
    @viteReactRefresh
@endsection
@section('content')
    <div id="root"></div>
    @vite('resources/js/mainViewActivity.jsx')
@endsection
@section('script')
    <script>
        window.by = @json($by)
    </script>
@endsection
