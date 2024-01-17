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
                @role(['Super-Admin','Insurance'])
                <li>
                    <a class="{{ request()->is('Insurance/Broker') ? 'active' : '' }}" href="{{ url('Insurance/Broker') }}"><i class="la la-object-ungroup"></i> <span> Broker</span></a>
                </li>
                <li>
                    <a class="{{ request()->is('Insurance/Insurer') ? 'active' : '' }}" href="{{ url('Insurance/Insurer') }}"><i class="la la-object-ungroup"></i> <span> Insurer</span></a>
                </li>
                <li>
                    <a class="{{ request()->is('Insurance/Type') ? 'active' : '' }}" href="{{ url('Insurance/Type') }}"><i class="la la-object-ungroup"></i> <span> Type</span></a>
                </li>
                <li>
                    <a class="{{ request()->is('NavCompany') ? 'active' : '' }}" href="{{ url('NavCompany') }}"><i class="la la-object-ungroup"></i> <span> Entity</span></a>
                </li>
                @endrole
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
                            <a class="{{ request()->is('crewing/report') ? 'active' : '' }}" href="{{ url('crewing/report') }}"> <span>Report Crew</span></a>
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
                    <li class="submenu">
                        <a href="#"><i class="la la-user-plus"></i> <span> Users</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->is('user') ? 'active' : '' }}" href="{{ url('user') }}">All Users</a></li>
                            <li><a class="{{ request()->is('userHasRoles') ? 'active' : '' }}" href="{{ url('userHasRoles') }}">User Has Roles</a></li>
                        </ul>
                    </li>
                    @endcan
                    @can('lihat-role')
                    <li class="submenu">
                        <a href="#"><i class="la la-object-ungroup"></i> <span> Roles</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->is('role') ? 'active' : '' }}" href="{{ url('role') }}">All Roles</a></li>
                            <li><a class="{{ request()->is('roleHasPermission') ? 'active' : '' }}" href="{{ url('roleHasPermission') }}">Role has Permission</a></li>
                        </ul>
                    </li>
                    @endcan
                    @can('lihat-permission')
                    <li class="submenu">
                        <a href="#"><i class="la la-object-ungroup"></i> <span> Permission</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->is('permission') ? 'active' : '' }}" href="{{ url('permission') }}">All Permission</a></li>
                        </ul>
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
