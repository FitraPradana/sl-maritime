<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @canany(['home'])
                <li class="menu-title">
                    <span>Main</span>
                </li>
                    @can('home')
                    <li>
                        <a class="{{ request()->is('Home') ? 'active' : '' }}" href="{{ url('Home') }}"><i class="la la-dashboard"></i> <span> Dashboard</span></a>
                    </li>
                    @endcan
                @endcanany

                @canany(['lihat-ticketing'])
                <li class="menu-title">
                    <span>Information Technology</span>
                </li>
                    @can('lihat-ticketing')
                    <li class="submenu">
                        <a href="#"><i class="la la-ticket"></i> <span> Tickets</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->is('ticketing') ? 'active' : '' }}" href="{{ url('ticketing') }}">All Tickets</a></li>
                        </ul>
                    </li>
                    @endcan
                @endcanany


                @canany(['lihat-insurance-renewal','lihat-insurance-payment'])
                <li class="menu-title">
                    <span>Insurance</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-file-pdf-o"></i> <span> Insurance</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        @can('lihat-insurance-renewal')
                            <a class="{{ request()->is('insurance/renewal_monitoring') ? 'active' : '' }}" href="{{ url('insurance/renewal_monitoring') }}"> <span>Insurance Monitoring</span></a>
                        @endcan
                        @can('lihat-insurance-payment')
                            <a class="{{ request()->is('insurance/payment_monitoring') ? 'active' : '' }}" href="{{ url('insurance/payment_monitoring') }}"> <span>Insurance Payment Monitoring</span></a>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['lihat-crewing','report1-crewing'])
                <li class="menu-title">
                    <span>Crewing</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="las la-anchor"></i> <span> Crewing</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        @can('report1-crewing')
                            <a class="" href=""> <span>Report Crew</span></a>
                        @endcan
                    </ul>
                </li>
                @endcanany

                @canany(['lihat-user','lihat-employee'])
                <li class="menu-title">
                    <span>Administration</span>
                </li>
                    @can('lihat-employee')
                    <li class="submenu">
                        <a href="#"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->is('employee') ? 'active' : '' }}" href="{{ url('employee') }}">All Employees</a></li>
                        </ul>
                    </li>
                    @endcan
                    @can('lihat-user')
                    <li>
                        <a {{ request()->is('user') ? 'active' : '' }} href="{{ url('user') }}"><i class="la la-user-plus"></i> <span>Users</span></a>
                    </li>
                    @endcan
                @endcanany
                {{-- <li>
                    <a href="#"><i class="la la-cog"></i> <span>Settings</span></a>
                </li>
                <li class="menu-title">
                    <span>Pages</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-user"></i> <span> Profile </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="profile.html"> Employee Profile </a></li>
                        <li><a href="client-profile.html"> Client Profile </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-key"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="login.html"> Login </a></li>
                        <li><a href="register.html"> Register </a></li>
                        <li><a href="forgot-password.html"> Forgot Password </a></li>
                        <li><a href="otp.html"> OTP </a></li>
                        <li><a href="lock-screen.html"> Lock Screen </a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
