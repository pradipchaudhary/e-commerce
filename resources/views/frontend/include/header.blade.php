<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>

    <!-- CSS only -->

    <link rel="stylesheet" href="{{ asset('user/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('user/assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/assets/css/magnific-popup.css') }}">
</head>

<body>
    @include('sweetalert::alert')

    <div id="button"></div>
    {{-- === TOP WRAP === --}}
    <header>
        <div id="top_wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="offer-title"> Quality New and Used cell phones and accessories</div>
                    </div>
                    <div class="col-md-6">
                        <div class="top-links">
                            <a href="#" class="link-item"> Today's Deal </a>
                            <a href="#" class="link-item"> Customer Service </a>
                            <a href="#" class="link-item"> Track Order </a>
                        </div>
                        {{-- <div class="top_login">
                            @if (auth()->user() == null)
                                <a href="{{ url('/register') }}">Register </a>/
                                <a href="{{ url('/login') }}">Sign in</a>
                            @else
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ 'Welcome ' . auth()->user()->name }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item"
                                                href="{{ !auth()->user()->hasRole(config('CONSTANT.USER_ROLE'))? url('home'): route('user.dashboard') }}"
                                                style="color: black !important;">Order History</a></li>
                                        @if (auth()->user()->hasRole(config('CONSTANT.USER_ROLE')))
                                            <li><a class="dropdown-item" href="{{ route('user.profile') }}"
                                                    style="color: black !important;">Profile</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.dashboard.offer') }}"
                                                    style="color: black !important;">Offer</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('user.dashboard.change_password') }}"
                                                    style="color: black !important;">Password Change</a></li>
                                        @endif
                                    </ul>
                                    <a onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"
                                        class="mx-2" style="cursor:pointer !important;">Logout
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </a>
                                </div>
                            @endif
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- fix on scroll class sticky-top --}}


        <div class="container">
            <div class="row">
                <div class="header">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img class="brand-logo" src="{{ asset('logo.jpg') }}" alt="">
                            <div class="text">
                                <h4>Everest Phones </h4>
                                <span> Phones/Accessories/Simcards </span>
                            </div>
                        </a>
                    </div>
                    <div class="search_box">
                        <input type="text" placeholder="Search here..">
                        <button> Search </button>
                    </div>
                    <div class="header-info">
                        <li class="number">
                            <div class="icon"> <i class="fa-solid fa-headphones"></i> </div>
                            <div class="info">
                                <span class="text-number">Number</span>
                                <span class="number-text"> 919-377-0131 </span>
                            </div>
                        </li>
                        <li class="account">
                            <div class="icon"> <i class="fa-regular fa-user"></i> </div>
                            <div class="info">
                                <span class="text-number">Account</span>
                                <span class="number-text"> sign in </span>
                            </div>
                            @if (auth()->user() == null)
                                <a href="{{ url('/register') }}">Register </a>/
                                <a href="{{ url('/login') }}">Sign in</a>
                            @else
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ 'Welcome ' . auth()->user()->name }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item"
                                                href="{{ !auth()->user()->hasRole(config('CONSTANT.USER_ROLE'))? url('home'): route('user.dashboard') }}"
                                                style="color: black !important;">Order History</a></li>
                                        @if (auth()->user()->hasRole(config('CONSTANT.USER_ROLE')))
                                            <li><a class="dropdown-item" href="{{ route('user.profile') }}"
                                                    style="color: black !important;">Profile</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.dashboard.offer') }}"
                                                    style="color: black !important;">Offer</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('user.dashboard.change_password') }}"
                                                    style="color: black !important;">Password Change</a></li>
                                        @endif
                                    </ul>
                                    <a onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"
                                        class="mx-2" style="cursor:pointer !important;">Logout
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </a>
                                </div>
                            @endif
                        </li>
                    </div>
                    @if (auth()->user() != null)
                    @endif
                </div>
            </div>
        </div>
    </header>
