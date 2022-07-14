<div class="sidebar pe-4 pb-3 shadow">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="{{ route('index') }}" class="navbar-brand mx-5 mb-3">
            <h4 class="text-primary">550MCH Lab</h4>
        </a>
        <div class="d-flex align-items-center ms-4 mb-3">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ isset(Auth::user()->photo) ? asset('storage/profile_thumbnails/'.Auth::user()->photo) : asset('user_default.png') }}" alt=""
                     style="width: 40px; height: 40px;">
                </div>
            <div class="ms-3">
                <h6 class="mb-0 text-primary">{{ Auth::user()->name }}</h6>
                <span class="text-black-50" style="font-size: 13px">{{ Auth::user()->role == 0 ? 'Admin':'Staff' }}</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <p class="menu-header mb-0">Main</p>
            <x-side-bar-link link="{{ route('index') }}" class="fa-dashboard" name="Dashboard" />
            <x-side-bar-link link="{{ route('listing') }}" class="fa-list" name="Listings" />
            <div class="menu-spacer"></div>

            <p class="menu-header mb-0">Data</p>
            <x-side-bar-link link="{{ route('test_value.index') }}" class="fa-flask-vial" name="Tests" />
            <div class="menu-spacer"></div>
            <p class="menu-header mb-0">Laboratory Setting</p>
            <div class="item">
                <a href="#" class="nav-item nav-link sub-btn mb-1">
                    <i class="fa-solid fa-cogs me-2"></i>Lab Info
                    <i class="fa-solid fa-chevron-down float-end custom-dropdown"></i>
                </a>
                <div class="sub-menu ms-4">
                    <a href="{{ route('test_type.create') }}" class="dropdown-item mb-2 {{ route('test_type.create')==request()->url() ? 'active':'' }}"><i class="fa-solid fa-chevron-right me-3"></i>Test Types</a>
                    @if(auth()->user()->role == 0)
                    <a href="{{ route('department.create') }}" class="dropdown-item mb-2 {{ route('department.create')==request()->url() ? 'active':'' }}"><i class="fa-solid fa-chevron-right me-3"></i>Departments</a>
                    <a href="{{ route('hospital.create') }}" class="dropdown-item mb-2 {{ route('hospital.create')==request()->url() ? 'active':'' }}"><i class="fa-solid fa-chevron-right me-3"></i>Hospitals</a>
                    <a href="{{ route('users') }}" class="dropdown-item mb-2 {{ route('users')==request()->url() ? 'active':'' }}"><i class="fa-solid fa-chevron-right me-3"></i>Users</a>
                    @endif
                </div>
            </div>
            <div class="menu-spacer"></div>

            <p class="menu-header mb-0">User Setting</p>
            <x-side-bar-link link="{{ route('profile') }}" class="fa-user-cog" name="Profile" />
        </div>
    </nav>
</div>
