<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Connect CRM')</title>
    <meta name="description" content="@yield('description', 'Connect Customer Relationship Management')">
    <meta name="keywords" content="@yield('keywords', 'Connect CRM Customer Relationship Management')">
    <meta name="author" content="@yield('author', 'Mg Nay Aung Lin')">
    <link rel="icon" href="{{ url('/default_images/connect_transparent.png') }}">
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&family=Montserrat:wght@300;500&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@700&family=Inter&family=Montserrat:wght@300;500&display=swap"
        rel="stylesheet">
    <!-- appvarun totastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- jquery-confirm -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- custom css -->
    <link rel="stylesheet" href="{{ url('/css/custom.css') }}">

    @yield('css')
</head>

<body>
    <!-- top navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-0 fixed-top me-auto">
        <div class="container-fluid ps-3">
            <!-- offcanvas trigger -->
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#offcanvasExample"></span>
            </button>
            <!-- end offcanvas trigger -->
            <a class="navbar-brand me-auto" href="{{ url('/') }}">
                <img src="{{ url('/default_images/connect_transparent.png') }}" width="60" height="60"
                    class="d-inline-block" alt="connect crm logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav text-center ms-auto col-nav-me">
                    {{-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li> --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="rounded-circle" width="30" height="30"
                                src="{{ url('/storage/images/' . Auth::guard($role)->user()->image) }}"
                                alt="{{ Auth::guard($role)->user()->name }}">
                        </a>
                        <ul class="dropdown-menu p-0" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
                            <div class="dropdown-divider m-0 p-0"></div>
                            <li>
                                <a class="dropdown-item ps-1 pb-0">
                                    <form action="{{ url('/logout') }}" class="d-inline" method="POST">
                                        @csrf
                                        <button class="btn bg-transparent" type="submit">Logout</button>
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- end top navbar -->
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start bg-dark text-white sidebar-nav" tabindex="-1" id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                            Main
                        </div>
                    </li>
                    <li>
                        <a href="/" class="nav-link px-3 {{ request()->is('/') ? 'active' : '' }}">
                            <span class="me-2">
                                <i class="bi bi-speedometer2"></i>
                            </span>
                            <span>Dashbord</span>
                        </a>
                    </li>
                    <li>
                        <p>
                            <a class="nav-link px-3 sidebar-link {{ request()->is('contact*') ? 'active' : '' }}"
                                data-bs-toggle="collapse" href="#collapseContact" role="button"
                                aria-expanded="false" aria-controls="collapseExample">
                                <span class="me-2">
                                    <i class="bi bi-person-lines-fill"></i>
                                </span>
                                <span>Contacts</span>
                                <span class="right-icon ms-auto">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </a>
                        </p>
                        <div class="collapse {{ request()->is('contact*') ? 'show' : '' }}" id="collapseContact">
                            <div>
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="{{ url('/contact/create') }}"
                                            class="nav-link px-3 {{ request()->is('contact/create') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-plus-circle"></i>
                                            </span>
                                            <span>Create</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/contact/view') }}"
                                            class="nav-link px-3 {{ request()->is('contact/view') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                            <span>View</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <p>
                            <a class="nav-link px-3 sidebar-link {{ request()->is('lead*') ? 'active' : '' }}"
                                data-bs-toggle="collapse" href="#collapseLead" role="button" aria-expanded="false"
                                aria-controls="collapseExample">
                                <span class="me-2">
                                    <i class="bi bi-people-fill"></i>
                                </span>
                                <span>Leads</span>
                                <span class="right-icon ms-auto">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </a>
                        </p>
                        <div class="collapse {{ request()->is('lead*') ? 'show' : '' }}" id="collapseLead">
                            <div>
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="{{ url('/lead/create') }}"
                                            class="nav-link px-3 {{ request()->is('lead/create') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-plus-circle"></i>
                                            </span>
                                            <span>Create</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/lead/view') }}"
                                            class="nav-link px-3 {{ request()->is('lead/view') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                            <span>View</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <p>
                            <a class="nav-link px-3 sidebar-link {{ request()->is('activity*') ? 'active' : '' }}"
                                data-bs-toggle="collapse" href="#collapseActivity" role="button"
                                aria-expanded="false" aria-controls="collapseExample">
                                <span class="me-2">
                                    <i class="bi bi-list-task"></i>
                                </span>
                                <span>Activity</span>
                                <span class="right-icon ms-auto">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </a>
                        </p>
                        <div class="collapse {{ request()->is('activity*') ? 'show' : '' }}" id="collapseActivity">
                            <div>
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="{{ url('/activity/view') }}"
                                            class="nav-link px-3 {{ request()->is('activity/view') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                            <span>View</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="my-2">
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                            Resources
                        </div>
                    </li>
                    <li>
                        <p>
                            <a class="nav-link px-3 sidebar-link {{ request()->is('business*') ? 'active' : '' }}"
                                data-bs-toggle="collapse" href="#collapseBusiness" role="button"
                                aria-expanded="false" aria-controls="collapseExample">
                                <span class="me-2">
                                    <i class="bi bi-briefcase"></i>
                                </span>
                                <span>Business</span>
                                <span class="right-icon ms-auto">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </a>
                        </p>
                        <div class="collapse {{ request()->is('business*') ? 'show' : '' }}" id="collapseBusiness">
                            <div>
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="{{ url('/business/create') }}"
                                            class="nav-link px-3 {{ request()->is('business/create') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-plus-circle"></i>
                                            </span>
                                            <span>Create</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/business/view') }}"
                                            class="nav-link px-3 {{ request()->is('business/view') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                            <span>View</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <p>
                            <a class="nav-link px-3 sidebar-link {{ request()->is('product*') ? 'active' : '' }}"
                                data-bs-toggle="collapse" href="#collapseProduct" role="button"
                                aria-expanded="false" aria-controls="collapseExample">
                                <span class="me-2">
                                    <i class="bi bi-box"></i>
                                </span>
                                <span>Product</span>
                                <span class="right-icon ms-auto">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </a>
                        </p>
                        <div class="collapse {{ request()->is('product*') ? 'show' : '' }}" id="collapseProduct">
                            <div>
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="{{ url('/product/create') }}"
                                            class="nav-link px-3 {{ request()->is('product/create') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-plus-circle"></i>
                                            </span>
                                            <span>Create</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/product/view') }}"
                                            class="nav-link px-3 {{ request()->is('product/view') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                            <span>View</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <p>
                            <a class="nav-link px-3 sidebar-link {{ request()->is('source*') ? 'active' : '' }}"
                                data-bs-toggle="collapse" href="#collapseSource" role="button"
                                aria-expanded="false" aria-controls="collapseExample">
                                <span class="me-2">
                                    <i class="bi bi-megaphone"></i>
                                </span>
                                <span>Source</span>
                                <span class="right-icon ms-auto">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </a>
                        </p>
                        <div class="collapse {{ request()->is('source*') ? 'show' : '' }}" id="collapseSource">
                            <div>
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="{{ url('/source/create') }}"
                                            class="nav-link px-3 {{ request()->is('source/create') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-plus-circle"></i>
                                            </span>
                                            <span>Create</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/source/view') }}"
                                            class="nav-link px-3 {{ request()->is('source/view') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                            <span>View</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <p>
                            <a class="nav-link px-3 sidebar-link {{ request()->is('org*') ? 'active' : '' }}"
                                data-bs-toggle="collapse" href="#collapseOrg" role="button" aria-expanded="false"
                                aria-controls="collapseExample">
                                <span class="me-2">
                                    <i class="bi bi-building"></i>
                                </span>
                                <span>Organizations</span>
                                <span class="right-icon ms-auto">
                                    <i class="bi bi-chevron-down"></i>
                                </span>
                            </a>
                        </p>
                        <div class="collapse {{ request()->is('org*') ? 'show' : '' }}" id="collapseOrg">
                            <div>
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="{{ url('/org/create') }}"
                                            class="nav-link px-3 {{ request()->is('org/create') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-plus-circle"></i>
                                            </span>
                                            <span>Create</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/org/view') }}"
                                            class="nav-link px-3 {{ request()->is('org/view') ? 'active' : '' }}">
                                            <span class="me-2">
                                                <i class="bi bi-eye"></i>
                                            </span>
                                            <span>View</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    @auth('admin')
                        <li>
                            <p>
                                <a class="nav-link px-3 sidebar-link {{ request()->is('account-manage*') ? 'active' : '' }}"
                                    data-bs-toggle="collapse" href="#collapseAccountManage" role="button"
                                    aria-expanded="false" aria-controls="collapseExample">
                                    <span class="me-2">
                                        <i class="bi bi-person-video2"></i>
                                    </span>
                                    <span>Account Manage</span>
                                    <span class="right-icon ms-auto">
                                        <i class="bi bi-chevron-down"></i>
                                    </span>
                                </a>
                            </p>
                            <div class="collapse {{ request()->is('account-manage*') ? 'show' : '' }}"
                                id="collapseAccountManage">
                                <div>
                                    <ul class="navbar-nav ps-3">
                                        <li>
                                            <a href="{{ url('/account-manage/search') }}"
                                                class="nav-link px-3 {{ request()->is('account-manage/search') ? 'active' : '' }}">
                                                <span class="me-2">
                                                    <i class="bi bi-search"></i>
                                                </span>
                                                <span>Search</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endauth
                    <li class="my-2">
                        <hr class="dropdown-divider" />
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- end offcanvas -->
    <main class="mt-5 pt-3">
        <div class="container mb-2">
            @yield('content')
        </div>
    </main>
    <!-- bootstrap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- jquery cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- appvaran Toastify -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- jquery-confirm -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <!-- select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- custom scripts -->
    @include('layout.custom-scripts')

    @yield('script')
</body>

</html>
