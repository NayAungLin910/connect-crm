@extends('layout.master')
@section('title', 'Profile - Connect CRM')
@section('description', 'Profile page of the Connect Customer Relationship Management')
@section('keywords', 'Profile Connect CRM Customer Relationship Management')
@section('content')
    <div class="row mt-4">
        <div class="col-sm-4">
            <div class="text-center">
                <img class="rounded-circle" width="100" height="100" src="{{ url('/storage/images/' . $user->image) }}"
                    alt="{{ $user->name }}">
            </div>
            <h4 class="text-center mt-2">{{ $user->name }}</h4>
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <i class="bi bi-envelope mx-1"></i>
                            Email
                        </td>
                        <td class="text-end">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>
                            <i class="bi bi-people-fill mx-1"></i>
                            Leads
                        </td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-primary" href="{{ url('/lead/view?by=me') }}">
                                {{ $user->lead_count }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <i class="bi bi-list-task mx-1"></i>
                            Activities
                        </td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-primary" href="{{ url('/activity/view?by=me') }}">
                                {{ $user->activity_count }}
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ url('/edit-profile') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-pencil-square mx-1"></i>
                    Edit Profile
                </a>
                <a href="{{ url('/change-password') }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil-square mx-1"></i>
                    Change Password
                </a>
            </div>
        </div>
    </div>
@endsection
