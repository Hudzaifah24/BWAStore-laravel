<nav
    class="
    navbar navbar-expand-lg navbar-light navbar-store
    fixed-top
    navbar-fixed-top
    "
    data-aos="fade-down"
>
    <div class="container">
    <a href="{{ route('home') }}" class="navbar-brand">
        <img src="/images/logo.svg" alt="Logo" />
    </a>
    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarResponsive"
    >
        <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ (request()->is('home*')) ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item {{ (request()->is('categories*')) ? 'active' : '' }}">
                    <a href="{{ route('categories') }}" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Rewards</a>
                </li>
                @guest
                    <li class="nav-item {{ (request()->is('register*')) ? 'active' : '' }}">
                        <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a
                        href="{{ route('login') }}"
                        class="btn btn-success nav-link px-4 text-light"
                        >Sign In</a
                        >
                    </li>
                @endguest
            </ul>

            @auth
                <ul class="navbar-nav d-none d-lg-flex">
                    <li class="nav-item dropdown">
                        <a
                            href=""
                            class="nav-link"
                            id="navbarDropdown"
                            role="button"
                            data-toggle="dropdown"
                        >
                            <img
                            src="/images/pp.jpeg"
                            class="rounded-circle mr-2 profile-picture"
                            alt=""
                            />
                        </a>
                        <div class="dropdown-menu">
                            <p class="dropdown-item">Hi, {{ Auth::user()->name }}</p>
                            <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                            <a href="{{ route('dashboard-settings-account') }}" class="dropdown-item">
                                Setting
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                                class="dropdown-item">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                            @php
                                $carts = \App\Cart::where('users_id', Auth::user()->id)->count();
                            @endphp
                            @if ($carts > 0)
                                <img src="/images/icon-cart-filled.svg" alt="" />
                                <div class="card-badge" style="border-radius: 100%">{{ $carts }}</div>
                            @else
                                <img src="/images/icon-cart-empty.svg" alt="" />
                            @endif
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav d-block d-lg-none">
                    <li class="nav-item">
                    <a href="#" class="nav-link"> Hi, Angga </a>
                    </li>
                    <li class="nav-item d-inline-block">
                    <a href="#" class="nav-link">Cart</a>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
