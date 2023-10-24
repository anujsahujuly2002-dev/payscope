@php
    $permission = ['admin.permission.list','admin.role.list'];
    $member = ['admin.api.partner.list'];
    @endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{route('admin.dashboard')}}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{asset('assets/img/logo/logo1.jpeg')}}" alt="" srcset="">                 
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item @if(request()->route()->getName() =='admin.dashboard') active @endif">
            <a href="{{route('admin.dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Role And Permission -->
        @canany(['role-list', 'role-delete', 'role-create','role-edit','permission-list','permssion-create','permission-edit','permission-delete'])
            <li class="menu-item @if(in_array(request()->route()->getName(),$permission)) active open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Layouts">Role & Permission</div>
                </a>
                <ul class="menu-sub">
                    @canany(['role-list', 'role-delete', 'role-create','role-edit'])
                        <li class="menu-item @if(in_array(request()->route()->getName(),['admin.role.list'])) active @endif">
                            <a href="{{route('admin.role.list')}}" class="menu-link">
                                <div data-i18n="Without menu">Role</div>
                            </a>
                        </li>
                    @endcanany
                    @canany(['permission-list', 'permssion-create', 'permission-edit','permission-delete'])
                    <li class="menu-item @if(in_array(request()->route()->getName(),['admin.permission.list'])) active @endif">
                        <a href="{{route('admin.permission.list')}}" class="menu-link">
                            <div data-i18n="Without navbar">Permission</div>
                        </a>
                    </li>
                    @endcanany
                </ul>
            </li> 
        @endcanany
        <!--Member -->
        @canany(['api-partner-create', 'api-partner-list', 'api-partner-edit','api-partner-delete'])
            <li class="menu-item @if(in_array(request()->route()->getName(),$member)) active open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Layouts">Member</div>
                </a>
                <ul class="menu-sub">
                    @canany(['api-partner-create', 'api-partner-list', 'api-partner-edit','api-partner-delete'])
                        <li class="menu-item @if(in_array(request()->route()->getName(),['admin.api.partner.list'])) active @endif">
                            <a href="{{route('admin.api.partner.list')}}" class="menu-link">
                                <div data-i18n="Without menu">Api Partner</div>
                            </a>
                        </li>
                    @endcanany
                </ul>
            </li> 
        @endcanany

        {{-- Set Up Tools --}}
        @canany(['bank-create', 'bank-list', 'bank-edit','bank-delete'])
            <li class="menu-item @if(in_array(request()->route()->getName(),['admin.setup.bank'])) active open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div data-i18n="Layouts">Setup Tools</div>
                </a>
                <ul class="menu-sub">
                    @canany(['bank-create', 'bank-list', 'bank-edit','bank-delete'])
                        <li class="menu-item @if(in_array(request()->route()->getName(),['admin.setup.bank'])) active @endif">
                            <a href="{{route('admin.setup.bank')}}" class="menu-link">
                                <div data-i18n="Without menu">Bank Account</div>
                            </a>
                        </li>
                    @endcanany
                </ul>
            </li> 
        @endcanany

        {{-- Fund Transfer --}}
        @canany(['fund-manager-manual-request'])
            <li class="menu-item @if(in_array(request()->route()->getName(),['admin.fund.manual.request'])) active open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-wallet-alt"></i>
                    <div data-i18n="Layouts">Fund Manager</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item @if(in_array(request()->route()->getName(),['admin.fund.manual.request'])) active @endif">
                        <a href="{{route('admin.fund.manual.request')}}" class="menu-link">
                            <div data-i18n="Without menu">Manual Request </div>
                        </a>
                    </li>
                </ul>
            </li> 
        @endcanany
    </ul>
</aside>
<!-- / Menu -->