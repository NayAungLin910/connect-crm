<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', "Connect CRM")</title>
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
    <!-- custom css -->
    <link rel="stylesheet" href="{{ url('/css/custom-auth.css') }}">

    @yield('css')
</head>

<body>
    <!-- top navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-0 fixed-top">
        <div class="container-fluid ps-3">
            <a class="navbar-brand me-auto" href="">
                <img src="{{ url('/default_images/connect_transparent.png') }}" width="60" height="60"
                    class="d-inline-block" alt="connect crm logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav text-center mx-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('login*') ? 'active' : '' }}" href="#"
                            id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Login
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ url('/login-admin') }}">Admin</a></li>
                            <li><a class="dropdown-item" href="{{ url('/login-moderator') }}">Moderator</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link {{ request()->is('register*') ? 'active' : '' }} dropdown-toggle"
                            href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Register
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ url('/register-admin') }}">Admin</a></li>
                            <li><a class="dropdown-item" href="{{ url('/register-moderator') }}">Moderator</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="mt-5 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <img class="m-0 p-0" src="{{ url('/default_images/connect.png') }}" width="250"
                        alt="Connect CRM">
                </div>
            </div>
            @yield('content')
        </div>
    </main>

    <!-- bootstrap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- appvaran Toastify -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- Session flashing -->
    @if (session()->has('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                // className: ['bg-danger'],
                style: {
                    background: "linear-gradient(to right, #F58C7E, #F02C11)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @if (session()->has('info'))
        <script>
            Toastify({
                text: "{{ session('info') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #9CB1E9, #5B82EA)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #76CA86, #35CD52)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    <!-- end session flashing -->

    @yield('script')
</body>

</html>
