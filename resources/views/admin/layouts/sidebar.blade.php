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
        {{-- Resource Manage --}}

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-wrench"></i>
                <div data-i18n="Layouts">Resources</div>
            </a>
            <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link">
                            <div data-i18n="Without menu">Scheme Manager</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link">
                            <div data-i18n="Without menu">Company Manager</div>
                        </a>
                    </li>

                <li class="menu-item">
                    <a href="javascript:void()" class="menu-link">
                        <div data-i18n="Without navbar">Company Profile</div>
                    </a>
                </li>

            </ul>
        </li>
        {{-- Resource Manage --}}
        <!-- Role And Permission -->
        @canany(['role-list', 'role-delete', 'role-create','role-edit','permission-list','permssion-create','permission-edit','permission-delete'])
            <li class="menu-item @if(in_array(request()->route()->getName(),$permission)) active open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-lock-alt"></i>
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
                    <li class="menu-item ">
                        <a href="javascript:void(0)" class="menu-link">
                            <div data-i18n="Without menu">Whitelabel</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="javascript:void(0)" class="menu-link">
                            <div data-i18n="Without menu">Master Distributor</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="javascript:void(0)" class="menu-link">
                            <div data-i18n="Without menu">Distributor</div>
                        </a>
                    </li>
                    <li class="menu-item ">
                        <a href="javascript:void(0)" class="menu-link">
                            <div data-i18n="Without menu">Retailer</div>
                        </a>
                    </li>
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
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link">
                            <div data-i18n="Without menu">Transfer / Return </div>
                        </a>
                    </li>

                    <li class="menu-item @if(in_array(request()->route()->getName(),['admin.fund.manual.request'])) active @endif">
                        <a href="{{route('admin.fund.manual.request')}}" class="menu-link">
                            <div data-i18n="Without menu">Request </div>
                        </a>
                    </li>
                   {{--  <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link">
                            <div data-i18n="Without menu">Request Report </div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link">
                            <div data-i18n="Without menu">Virtual Report </div>
                        </a>
                    </li> --}}
                </ul>
            </li>
        @endcanany

        {{-- Transaction History  --}}
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Layouts">Transaction History </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Without menu">Aeps </div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="javascript:void()" class="menu-link">
                        <div data-i18n="Without menu">Aadhar Pay </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Without menu">Bill Payment </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Without menu">Money Transfer </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Without menu">Mini Statement </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Without menu">Recharge  </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Without menu">Pancard </div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Transaction History  --}}
        {{-- Account Ledger  --}}
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-notepad"></i>
                <div data-i18n="Layouts">Account Ledger  </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Without menu">Main Wallet </div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="javascript:void()" class="menu-link">
                        <div data-i18n="Without menu">Aeps Wallet </div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Account Ledger  --}}
        {{-- Pending Approvals --}}
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-alarm"></i>
                <div data-i18n="Layouts"> Pending Approvals  </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Without menu">Complaints </div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="javascript:void()" class="menu-link">
                        <div data-i18n="Without menu">Payout Bank </div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Pending Approvals --}}
        {{-- Admin Setting --}}
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-alarm"></i>
                <div data-i18n="Layouts"> Admin Setting  </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Without menu">Api Manager </div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="javascript:void()" class="menu-link">
                        <div data-i18n="Without menu">Bank Manager </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void()" class="menu-link">
                        <div data-i18n="Without menu">Complaint Subject </div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void()" class="menu-link">
                        <div data-i18n="Without menu">Operator Manager</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void()" class="menu-link">
                        <div data-i18n="Without menu">Portal Setting</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void()" class="menu-link">
                        <div data-i18n="Without menu">Quick Link</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Admin Setting --}}
        {{-- Log Manager --}}
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-alarm"></i>
                <div data-i18n="Layouts"> Log Manager  </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Without menu">Api Logs </div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="javascript:void()" class="menu-link">
                        <div data-i18n="Without menu">Login Session </div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Log Manager --}}
        {{-- Logout --}}
        <li class="menu-item @if(request()->route()->getName() =='admin.logout') active @endif">
            <a href="{{route('admin.logout')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div data-i18n="Analytics">Logout</div>
            </a>
        </li>
        {{-- Logout --}}
    </ul>
</aside>
<!-- / Menu -->
