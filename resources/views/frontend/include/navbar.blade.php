<nav class="navbar navbar-expand-lg " id="navbar">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Brands
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us
                    </a>
                </li>
                @if (auth()->user() != null)
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('stock_list') }}">Stock List
                        </a>
                    </li>
                @endif

                {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Orders </a></li>
                            <li>
                                <a class="dropdown-item" href="#">Notification Preferences</a>
                            </li>
                        </ul>
                    </li> --}}
                {{-- <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" style="cursor:pointer !important;">Logout
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </li> --}}
            </ul>
        </div>
    </div>
</nav>
</div>
<!-- Nav end -->
