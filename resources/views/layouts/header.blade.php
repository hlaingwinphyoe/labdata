<nav class="navbar navbar-expand bg-primary navbar-dark sticky-top px-4 py-0">
    <div class="container">
        <a href="#" class="sidebar-toggler flex-shrink-0 text-decoration-none">
            <i class="fa-solid fa-bars text-secondary"></i>
        </a>
        <div class="text-center">
            <h5 class="text-white mb-0 text-center">Clinical Laboratory Data (550 MCH)</h5>
        </div>

        <div class="navbar-nav align-items-center">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-lg-1" src="{{ isset(Auth::user()->photo) ? asset('storage/profile_thumbnails/'.Auth::user()->photo) : asset('user_default.png') }}" alt=""
                         style="width: 30px; height: 30px;">
                    <span class="d-none d-lg-inline-flex" style="font-size: 13px">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0 shadow">
                    <a href="{{ route('profile') }}" class="dropdown-item">
                        <i class="fa-solid fa-user-cog me-1"></i>
                        My Profile
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fa-solid fa-cogs me-1"></i>
                        Setting
                    </a>
                    <div class="dropdown-divider"></div>
                    <a  class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-sign-out-alt me-3"></i>{{ __('Logout') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
