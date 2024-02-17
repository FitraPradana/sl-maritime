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
                            <a class="{{ request()->is('Home') ? 'active' : '' }}" href="{{ url('Home') }}"><i
                                    class="la la-dashboard"></i> <span> Dashboard</span></a>
                        </li>
                    @endcan
                @endcanany

                @canany(['ticketing-read', 'phising-read'])
                    <li class="menu-title">
                        <span>Information Technology</span>
                    </li>
                    @can('ticketing-read')
                        <li class="submenu">
                            <a href="#"><i class="la la-ticket"></i> <span> Tickets</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a class="{{ request()->is('Ticketing') ? 'active' : '' }}"
                                        href="{{ url('Ticketing') }}">All Tickets</a></li>
                            </ul>
                        </li>
                    @endcan
                    @canany(['phising-target-read','phising-detected-read'])
                    <li class="submenu">
                        <a href="#"><i class="fa fa-universal-access"></i> <span> Phising</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @can('mst-insurance-broker-read')
                                <li><a class="{{ request()->is('PhisingTarget') ? 'active' : '' }}"
                                        href="{{ url('PhisingTarget') }}">Phising Target</a></li>
                            @endcan
                            @can('phising-detected-read')
                                <li><a class="{{ request()->is('PhisingDetected') ? 'active' : '' }}"
                                        href="{{ url('PhisingDetected') }}">Phising Detected</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                @endcanany
                @canany(['mst-insurance-broker-read', 'mst-insurance-type-read', 'mst-insurance-insurer-read',
                    'mst-NAVCompany-read'])
                    <li class="menu-title">
                        <span>Insurance</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-object-ungroup"></i> <span> Master Data Insurance</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @can('mst-insurance-broker-read')
                                <a class="{{ request()->is('Insurance/Broker') ? 'active' : '' }}"
                                    href="{{ url('Insurance/Broker') }}"><i class="la la-object-ungroup"></i> <span>
                                        Broker</span></a>
                            @endcan
                            @can('mst-insurance-insurer-read')
                                <a class="{{ request()->is('Insurance/Insurer') ? 'active' : '' }}"
                                    href="{{ url('Insurance/Insurer') }}"><i class="la la-object-ungroup"></i> <span>
                                        Insurer</span></a>
                            @endcan
                            @can('mst-insurance-type-read')
                                <a class="{{ request()->is('Insurance/Type') ? 'active' : '' }}"
                                    href="{{ url('Insurance/Type') }}"><i class="la la-object-ungroup"></i> <span>
                                        Type</span></a>
                            @endcan
                            @can('mst-NAVCompany-read')
                                <a class="{{ request()->is('NavCompany') ? 'active' : '' }}" href="{{ url('NavCompany') }}"><i
                                        class="la la-object-ungroup"></i> <span> Entity</span></a>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @canany(['insurance-renewal-read', 'insurance-payment-read'])
                    <li class="submenu">
                        <a href="#"><i class="la la-file-pdf-o"></i> <span> Insurance</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @can('insurance-renewal-read')
                                <a class="{{ request()->is('Insurance/RenewalMonitoring') ? 'active' : '' }}"
                                    href="{{ url('Insurance/RenewalMonitoring') }}"> <span>Insurance Monitoring</span></a>
                            @endcan
                            @can('insurance-payment-read')
                                <a class="{{ request()->is('Insurance/PaymentMonitoring') ? 'active' : '' }}"
                                    href="{{ url('Insurance/PaymentMonitoring') }}"> <span>Insurance Payment
                                        Monitoring</span></a>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @canany(['mst-crewing-read'])
                    <li class="menu-title">
                        <span>Crewing</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="las la-anchor"></i> <span> Crewing</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            @can('mst-crewing-report')
                                <a class="{{ request()->is('crewing/report') ? 'active' : '' }}"
                                    href="{{ url('crewing/report') }}"> <span>Report Crew</span></a>
                            @endcan
                        </ul>
                    </li>
                @endcanany

                @canany(['mst-employee-read', 'mst-user-read', 'mst-userHasRole-read', 'mst-userHasPermission-read',
                    'mst-role-read', 'mst-roleHasPermission-read', 'mst-permission-read'])
                    <li class="menu-title">
                        <span>Administration</span>
                    </li>
                    @can('mst-employee-read')
                        {{-- <li class="submenu">
                        <a href="#"><i class="la la-user"></i> <span> Employees</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ request()->is('employee') ? 'active' : '' }}" href="{{ url('employee') }}">All Employees</a></li>
                        </ul>
                    </li> --}}
                    @endcan
                    @canany(['mst-user-read', 'mst-userHasRole-read', 'mst-userHasRole-read'])
                        <li class="submenu">
                            <a href="#"><i class="la la-user-plus"></i> <span> Users</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @can('mst-user-read')
                                    <li><a class="{{ request()->is('Users') ? 'active' : '' }}" href="{{ url('Users') }}">All
                                            Users</a></li>
                                @endcan
                                @can('mst-userHasRole-read')
                                    <li><a class="{{ request()->is('UserHasRoles') ? 'active' : '' }}"
                                            href="{{ url('UserHasRoles') }}">User Has Roles</a></li>
                                @endcan
                                @can('mst-userHasPermission-read')
                                    <li><a class="{{ request()->is('UserHasPermission') ? 'active' : '' }}"
                                            href="{{ url('UserHasPermission') }}">User Has Permission</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany

                    @canany(['mst-role-read', 'mst-roleHasPermission-read'])
                        <li class="submenu">
                            <a href="#"><i class="la la-object-ungroup"></i> <span> Roles</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @can('mst-role-read')
                                    <li><a class="{{ request()->is('Roles') ? 'active' : '' }}" href="{{ url('Roles') }}">All
                                            Roles</a></li>
                                @endcan
                                @can('mst-roleHasPermission-read')
                                    <li><a class="{{ request()->is('RoleHasPermission') ? 'active' : '' }}"
                                            href="{{ url('RoleHasPermission') }}">Role has Permission</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcanany
                    @canany(['mst-permission-read'])
                        <li class="submenu">
                            <a href="#"><i class="la la-object-ungroup"></i> <span> Permission</span> <span
                                    class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                @can('mst-permission-read')
                                    <li><a class="{{ request()->is('Permissions') ? 'active' : '' }}"
                                            href="{{ url('Permissions') }}">All Permission</a></li>
                                @endcan
                            </ul>
                        </li>
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
                @endcanany
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
