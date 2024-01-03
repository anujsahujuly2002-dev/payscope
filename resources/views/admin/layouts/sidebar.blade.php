@php
    $permission = ['admin.permission.list','admin.role.list'];
    $member = ['admin.api.partner.list'];
@endphp
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{route('admin.dashboard')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('/assets/images/logo1.jpeg') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/images/logo1.jpeg') }}" alt="" height="20">
            </span>
        </a>
        <a href="{{route('admin.dashboard')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('/assets/images/logo1.jpeg') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/images/logo1.jpeg') }}" alt="" height="20">
            </span>
        </a>
    </div>
    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>
    <div data-simplebar class="sidebar-menu-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('translation.Menu')</li>
                <li>
                    <a href="{{route('admin.dashboard')}}">
                        <i class="uil-home-alt"></i>
                        {{-- <span class="badge rounded-pill bg-primary float-end">01</span> --}}
                        <span>@lang('translation.Dashboard')</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-invoice"></i>
                        <span>Resources</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Scheme Manager</a></li>
                        <li><a href="javascript:void()">Company Manager</a></li>
                        <li><a href="javascript:void()">Company Profile</a></li>
                    </ul>
                </li>
                @canany(['role-list', 'role-delete', 'role-create','role-edit','permission-list','permssion-create','permission-edit','permission-delete'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="uil-book-alt"></i>
                            <span>Role & Permission</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @canany(['role-list', 'role-delete', 'role-create','role-edit'])
                                <li><a href="{{route('admin.role.list')}}">Role</a></li>
                            @endcan
                            @canany(['permission-list', 'permssion-create', 'permission-edit','permission-delete'])
                                <li><a href="{{route('admin.permission.list')}}">Permission</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-alt"></i>
                        <span>Member</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Whitelabel</a></li>
                        <li><a href="javascript:void()">Master Distributor</a></li>
                        <li><a href="javascript:void()">Distributor</a></li>
                        <li><a href="javascript:void()">Retailer</a></li>
                        <li><a href="javascript:void()">Api Partner</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-alt"></i>
                        <span>Setup Tools</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Bank Account</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-alt"></i>
                        <span>Fund Manager</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Request</a></li>
                        <li><a href="javascript:void()">Transfer / Return </a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-alt"></i>
                        <span>Payout Manager</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Payout Request </a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-alt"></i>
                        <span>Transaction History </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Aeps </a></li>
                        <li><a href="javascript:void()">Aadhar Pay  </a></li>
                        <li><a href="javascript:void()">Bill Payment  </a></li>
                        <li><a href="javascript:void()">Money Transfer </a></li>
                        <li><a href="javascript:void()">Mini Statement </a></li>
                        <li><a href="javascript:void()">Recharge </a></li>
                        <li><a href="javascript:void()">Pancard </a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-alt"></i>
                        <span>Account Ledger </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Main Wallet</a></li>
                        <li><a href="javascript:void()">Aeps Wallet</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-alt"></i>
                        <span> Pending Approvals</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Complaints</a></li>
                        <li><a href="javascript:void()">Payout Bank</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-alt"></i>
                        <span> Admin Setting  </span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Api Manager </a></li>
                        <li><a href="javascript:void()">Bank Manager </a></li>
                        <li><a href="javascript:void()">Complaint Subject  </a></li>
                        <li><a href="javascript:void()">Operator Manager  </a></li>
                        <li><a href="javascript:void()">Portal Setting  </a></li>
                        <li><a href="javascript:void()">Quick Link </a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-alt"></i>
                        <span> Log Manager</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Api Logs</a></li>
                        <li><a href="javascript:void()">Login Session </a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('admin.logout')}}">
                        <i class="uil-home-alt"></i>
                        {{-- <span class="badge rounded-pill bg-primary float-end">01</span> --}}
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
