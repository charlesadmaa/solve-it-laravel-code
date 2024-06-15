<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{route('adminDashboard')}}">
                    <img class="brand-logo_2 auth_logo_2" src="{{ asset('app-assets/images/custom/logo.svg') }}">
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>

    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{ route('adminDashboard') }}">
                    <i data-feather="grid"></i><span class="menu-title text-truncate">Dashboard</span>
                </a>
            </li>
            <li class="nav-item d-none">
                <a class="d-flex align-items-center" href="index.html">
                    <i data-feather="grid"></i><span class="menu-title text-truncate">Dashboards</span>
                    <span class="badge badge-light-warning badge-pill ml-auto mr-1">2</span>
                </a>
                <ul class="menu-content">
                    <li class="active">
                        <a class="d-flex align-items-center" href="dashboard-analytics.html">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Analytics</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="dashboard-ecommerce.html">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">eCommerce</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!--Items-->

            <li class="navigation-header"><span>Moderate</span><i data-feather="more-horizontal"></i>

            <li class="nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="user"></i>
                    <span class="menu-title text-truncate">Users</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="{{ route('manageUser') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">List</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="{{ route('manageUserAdd') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Add User</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a class="d-flex align-items-center" href="javascript:void(0)">
                    <i data-feather='tool'></i>
                    <span class="menu-item text-truncate">Data sets</span></a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="{{route('manageDepartment')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Department</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="{{route('manageLevels')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Levels</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="{{route('manageInterest')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Interests</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="{{route('manageSchool')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Schools</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{route('manageLevels')}}">
                    <i data-feather='file-text'></i>
                    <span class="menu-title text-truncate">Blog</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="{{route('manageBlog')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">All</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="{{route('manageBlogAdd')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Add new </span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="{{route('manageCategory')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Categories</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="{{route('manageComment')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Comments</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="/">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Likes</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="d-flex align-items-center" href="#">
                <i data-feather='hash'></i>
                <span class="menu-title text-truncate">Forum</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="{{ route('manageForum') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">All</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="/">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Add new</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="{{ route('manageForumComment') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Comments</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='list'></i>
                <span class="menu-title text-truncate">Listing</span>
                </a>
                <ul class="menu-content">
                    <li>
                        <a class="d-flex align-items-center" href="{{ route('manageListing') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">All</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="{{ route('manageListingAdd') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Add new</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="{{route('manageListingTag')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Tags</span>
                        </a>
                    </li>
                    <li>
                        <a class="d-flex align-items-center" href="/">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Comments</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!--Application Settings--->
            <li class="navigation-header">
                <span>Application Settings</span>
                <i data-feather="more-horizontal"></i>
            </li>

            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{route('manageSettings')}}">
                    <i data-feather="settings"></i>
                    <span class="menu-title text-truncate">General</span>
                </a>
            </li>

        </ul>
    </div>

</div>
