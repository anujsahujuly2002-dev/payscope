@php
    $permission = ['admin.permission.list', 'admin.role.list'];
    $member = ['admin.api.partner.list'];
@endphp
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('/assets/images/small_logo.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('/assets/images/logo1.jpeg') }}" alt="" height="20">
            </span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
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
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="uil-home-alt"></i>
                        {{-- <span class="badge rounded-pill bg-primary float-end">01</span> --}}
                        <span style="color: #0a1d56">@lang('translation.Dashboard')</span>
                    </a>
                </li>
                @if (checkRecordHasPermission(['create', 'list']))
                    @canany(['create', 'list'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-bolt-alt"></i>
                                <span style="color: #0a1d56;">Recharge & Bill Payment</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if (checkRecordHasPermission(['create', 'list']))
                                    @canany(['create', 'list'])
                                        <li><a href="{{route('admin.recharge.and.bill.paymentsmobile.recharge')}}" style="color: #0a1d56;">Recharge </a></li>
                                    @endcanany
                                @endif
                                {{-- <li><a href="javascript:void()">DTH</a></li> --}}
                                <li><a href="javascript:void()" style="color: #0a1d56;">Electricity</a></li>
                            </ul>
                        </li>
                    @endcanany
                @endif
                @if (checkRecordHasPermission(['scheme-manager-list', 'scheme-manager-create', 'scheme-manager-edit']))

                    @canany(['scheme-manager-list', 'scheme-manager-create', 'scheme-manager-edit'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-head-cog"></i>
                                <span style="color: #0a1d56;">Resources</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if (checkRecordHasPermission(['scheme-manager-list', 'scheme-manager-create', 'scheme-manager-edit']))
                                    @canany(['scheme-manager-list', 'scheme-manager-create', 'scheme-manager-edit'])
                                        <li><a href="{{ route('admin.resource.scheme.manager') }}" style="color: #0a1d56;">Scheme Manager</a></li>
                                    @endcanany
                                @endif
                                <li><a href="javascript:void()" style="color: #0a1d56;">Company Manager</a></li>
                                <li><a href="javascript:void()" style="color: #0a1d56;">Company Profile</a></li>
                            </ul>
                        </li>
                    @endcanany
                @endif
                @if (checkRecordHasPermission([
                        'role-list',
                        'role-delete',
                        'role-create',
                        'role-edit',
                        'permission-list',
                        'permssion-create',
                        'permission-edit',
                        'permission-delete',
                    ]))
                    @canany(['role-list', 'role-delete', 'role-create', 'role-edit', 'permission-list',
                        'permssion-create', 'permission-edit', 'permission-delete'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-cog"></i>
                                <span style="color: #0a1d56;">Role & Permission</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if (checkRecordHasPermission(['role-list', 'role-delete', 'role-create', 'role-edit']))
                                    @canany(['role-list', 'role-delete', 'role-create', 'role-edit'])
                                        <li><a style="color: #0a1d56;" href="{{ route('admin.role.list') }}">Role</a></li>
                                    @endcan
                                @endif
                                @if (checkRecordHasPermission(['permission-list', 'permssion-create', 'permission-edit', 'permission-delete']))
                                    @canany(['permission-list', 'permssion-create', 'permission-edit', 'permission-delete'])
                                        <li><a style="color: #0a1d56;" href="{{ route('admin.permission.list') }}">Permission</a></li>
                                    @endcan
                                @endif
                            </ul>
                        </li>
                    @endcanany
                @endif
                @if (checkRecordHasPermission(array_merge(
                            ['api-partner-create', 'api-partner-list', 'api-partner-edit', 'api-partner-delete'],
                            ['retailer-list', 'retailer-create', 'retailer-edit', 'retailer-delete'])))
                    @canany(['api-partner-create', 'api-partner-list', 'api-partner-edit', 'api-partner-delete',
                        'retailer-list', 'retailer-create', 'retailer-edit', 'retailer-delete'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-users-alt"></i>
                                <span style="color: #0a1d56;">Member</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                {{--   <li><a href="javascript:void()">Whitelabel</a></li>
                                <li><a href="javascript:void()">Master Distributor</a></li>
                                <li><a href="javascript:void()">Distributor</a></li> --}}
                                @if (checkRecordHasPermission(['retailer-list', 'retailer-create', 'retailer-edit', 'retailer-delete']))
                                    @canany(['retailer-list', 'retailer-create', 'retailer-edit', 'retailer-delete'])
                                        <li><a style="color: #0a1d56;" href="{{route('admin.retailer.list')}}">Retailer</a></li>
                                    @endcanany
                                @endif
                                @if (checkRecordHasPermission(['api-partner-create', 'api-partner-list', 'api-partner-edit', 'api-partner-delete']))
                                    @canany(['api-partner-create', 'api-partner-list', 'api-partner-edit',
                                        'api-partner-delete'])
                                        <li><a style="color: #0a1d56;" href="{{ route('admin.api.partner.list') }}">Api Partner</a></li>
                                    @endcanany
                                @endif
                                <li><a href="javascript:void()">White Wallet</a></li>
                            </ul>
                        </li>
                    @endcanany
                @endif
                {{-- @if (checkRecordHasPermission(['bank-create', 'bank-list', 'bank-edit', 'bank-delete', 'operator-list', 'operator-create', 'operator-edit', 'operator-delete', 'benificiary-list', 'benificiary-create']))
                    @canany(['bank-create', 'bank-list', 'bank-edit', 'bank-delete', 'operator-list', 'operator-create', 'operator-edit', 'operator-delete', 'benificiary-list', 'benificiary-create'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-cog"></i>
                                <span>Setup Tools</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if (checkRecordHasPermission(['bank-create', 'bank-list', 'bank-edit', 'bank-delete']))
                                    @canany(['bank-create', 'bank-list', 'bank-edit', 'bank-delete'])
                                        <li><a href="{{route('admin.setup.bank')}}">Bank Account</a></li>
                                    @endcanany
                                @endif
                                @if (checkRecordHasPermission(['operator-list', 'operator-create', 'operator-edit', 'operator-delete']))
                                    @canany(['operator-list', 'operator-create', 'operator-edit', 'operator-delete'])
                                        <li><a href="{{route('admin.setup.operator.manager')}}">Slab Manage</a></li>
                                    @endcanany
                                @endif
                                @if (checkRecordHasPermission(['benificiary-list', 'benificiary-create']))
                                    @canany(['benificiary-list', 'benificiary-create'])
                                        <li><a href="{{route('admin.setup.benificiary.manage')}}">Benificiary Manage</a></li>
                                    @endcanany
                                @endif
                            </ul>
                        </li>
                    @endcanany
                @endif --}}
                {{--  @if (checkRecordHasPermission(['fund-manager-manual-request', 'fund-new-request', 'approved-fund-request', 'virtual-list']))
                    @canany(['fund-manager-manual-request', 'fund-new-request', '	approved-fund-request'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-money-insert"></i>
                                <span>Fund Manager</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if (checkRecordHasPermission(['fund-manager-manual-request', 'fund-new-request', 'approved-fund-request']))
                                    @canany(['fund-manager-manual-request', 'fund-new-request', 'approved-fund-request'])
                                        <li><a href="{{route('admin.fund.manual.request')}}">Request</a></li>
                                    @endcanany
                                @endif
                                @if (checkRecordHasPermission(['virtual-list']))
                                    @canany(['virtual-list'])
                                        <li><a href="{{route('admin.fund.virtual.request')}}">Virtual Load</a></li>
                                    @endcanany
                                @endif
                                <li><a href="javascript:void()">Transfer / Return </a></li>
                            </ul>
                        </li>
                    @endcanany
                @endif --}}

                @if (checkRecordHasPermission([
                        'fund-manager-manual-request',
                        'fund-new-request',
                        'approved-fund-request',
                        'virtual-list',
                        'payout-request',
                        'payout-new-request',
                        'fund-manager-transfer-return'

                    ]))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="uil-history"></i>
                            <span style="color: #0a1d56;">Fund Manager</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @if (checkRecordHasPermission(['fund-manager-manual-request', 'fund-new-request', 'approved-fund-request']))
                                @canany(['fund-manager-manual-request', 'fund-new-request', 'approved-fund-request'])
                                    <li><a style="color: #0a1d56;" href="{{ route('admin.fund.manual.request') }}">Manual Request</a></li>
                                @endcanany
                            @endif
                            @if (checkRecordHasPermission(['virtual-list']))
                                @canany(['virtual-list'])
                                    <li><a style="color: #0a1d56;" href="{{ route('admin.fund.virtual.request') }}">Virtual Request</a></li>
                                @endcanany
                            @endif
                            @if (['qr-request-add-fund', 'qr-request-add-list'])
                                @canany(['qr-request-add-fund', 'qr-request-list'])
                                    <li><a style="color: #0a1d56;" href="{{ route('admin.fund.qr.request') }}">QR Request</a></li>
                                @endcanany
                            @endif
                            @if (checkRecordHasPermission(['fund-manager-transfer-return', 'transfer-return-new-request']))
                            @canany(['fund-manager-transfer-return', 'transfer-return-new-request'])
                            <li><a href="{{route('admin.fund.transfer.return')}}" style="color: #0a1d56;">Transfer Return</a></li>
                            @endcanany
                            @endif
                            {{-- @if (['payout-request', 'payout-new-request'])
                                @canany(['payout-request', 'payout-new-request'])
                                    <li><a href="{{route('admin.payout.payout.request')}}">Payout Request </a></li>
                                @endcanany
                             @endif --}}
                            {{--  <li><a href="javascript:void()">Aeps </a></li>
                            <li><a href="javascript:void()">Aadhar Pay  </a></li>
                            <li><a href="javascript:void()">Bill Payment  </a></li>
                            <li><a href="javascript:void()">Money Transfer </a></li>
                            <li><a href="javascript:void()">Mini Statement </a></li>
                            <li><a href="javascript:void()">Recharge </a></li>
                            <li><a href="javascript:void()">Pancard </a></li> --}}
                        </ul>
                    </li>
                @endif

                @if (checkRecordHasPermission(['payout-request', 'payout-new-request', 'qr-request-add-fund', 'qr-request-add-list']))
                    @canany(['payout-request', 'payout-new-request', 'qr-request-add-fund', 'qr-request-add-list'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-money-withdrawal"></i>
                                <span style="color: #0a1d56;">Payout Manager</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if (['payout-request', 'payout-new-request'])
                                    @canany(['payout-request', 'payout-new-request'])
                                        <li><a style="color: #0a1d56;" href="{{ route('admin.payout.payout.request') }}">Payout Request </a></li>
                                    @endcanany
                                @endif

                                <li><a href="javascript:void()" style="color: #0a1d56;">Bulk Payout</a></li>
                                <li><a href="javascript:void()" style="color: #0a1d56;">Schedule Payout</a></li>
                                <li><a href="javascript:void()" style="color: #0a1d56;">Payout Links</a></li>
                            </ul>
                        </li>
                    @endcanany
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-book-open"></i>
                        <span style="color: #0a1d56;">Wallet Statement</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()" style="color: #0a1d56;">Main Wallet</a></li>
                        <li><a href="javascript:void()" style="color: #0a1d56;">Api Wallet</a></li>
                    </ul>
                </li>
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="far fa-clock"></i>
                        <span> Pending Approvals</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="javascript:void()">Complaints</a></li>
                        <li><a href="javascript:void()">Payout Bank</a></li>
                    </ul>
                </li> --}}
                @if (checkRecordHasPermission([
                        'api-create',
                        'api-list',
                        'api-change-status',
                        'api-edit',
                        'manage-setting',
                        'setting-update',
                        'callback-token-create','callback-token-delete','login-session',
                    ]))
                    @canany(['api-create', 'api-list', 'api-change-status', 'api-edit', 'callback-token', 'callback-token-create','callback-token-delete','login-session',])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-cog"></i>
                                <span style="color: #0a1d56;">Setup Tools</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if (checkRecordHasPermission([
                                        'api-create',
                                        'api-list',
                                        'api-change-status',
                                        'api-edit',
                                        'login-session',
                                        'api-logs',
                                        'callback-token',
                                        'callback-token-create',
                                        'callback-token-delete',
                                    ]))
                                    @canany(['api-create', 'api-list', 'api-change-status', 'api-edit',
                                        'api-logs'])
                                        <li><a style="color: #0a1d56;" href="{{ route('admin.admin-setting.api.list') }}">Api Manager </a></li>
                                    @endcanany
                                @endif
                                <li><a href="javascript:void()">Operator Manager</a></li>
                                @if (checkRecordHasPermission(['api-logs']))
                                    @can('api-logs')
                                        <li><a style="color: #0a1d56;" href="{{ route('admin.log.manager.api.logs') }}">Api Logs</a></li>
                                    @endcan
                                @endif
                                @if (checkRecordHasPermission(['login-session']))
                                    @can('login-session')
                                        <li><a style="color: #0a1d56;" href="{{ route('admin.log.manager.login.session') }}">Login Session </a></li>
                                    @endcan
                                @endif
                                @if (checkRecordHasPermission(['callback-token', 'callback-token-create', 'callback-token-delete']))
                                    @canany(['callback-token', 'callback-token-create', 'callback-token-delete'])
                                        <li><a style="color: #0a1d56;" href="{{ route('admin.api.setting') }}">Callback & Token</a></li>
                                    @endcanany
                                @endif
                                {{-- @if (checkRecordHasPermission(['manage-service', 'service-create']))
                                    @canany(['manage-service', 'service-create'])
                                        <li><a href="{{route('admin.admin-setting.manage.service')}}">Service Manage</a></li>
                                    @endcanany
                                @endif --}}

                                {{-- @if (checkRecordHasPermission(['manage-setting', 'setting-update']))
                                   @canany(['manage-setting', 'setting-create'])
                                     <li><a href="{{route('admin.admin-setting.setting')}}">Setting</a></li>
                                   @endcan
                                @endif --}}
                            </ul>
                        </li>
                    @endcanany
                @endif
                {{-- @if (checkRecordHasPermission(['login-session', 'api-logs']))
                    @canany(['login-session', 'api-logs'])
                        <li>
                            <a href="javascript:void(0)" class="has-arrow waves-effect">
                                <i class="fas fa-book-open"></i>
                                <span> Log Manager</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if (checkRecordHasPermission(['api-logs']))
                                 @can('api-logs')
                                    <li><a href="{{route('admin.log.manager.api.logs')}}">Api Logs</a></li>
                                @endcan
                                @endif
                                @if (checkRecordHasPermission(['login-session']))
                                    @can('login-session')
                                        <li><a href="{{route('admin.log.manager.login.session')}}">Login Session </a></li>
                                    @endcan
                                @endif
                            </ul>
                        </li>
                    @endcanany
                @endif --}}
                {{-- @if (checkRecordHasPermission(['callback-token', 'callback-token-create', 'callback-token-delete']))
                    @canany(['callback-token', 'callback-token-create', 'callback-token-delete'])
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-cog"></i>
                                <span>Api Setting</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                @if (checkRecordHasPermission(['callback-token', 'callback-token-create', 'callback-token-delete']))
                                    @canany(['callback-token', 'callback-token-create', 'callback-token-delete'])
                                        <li><a href="{{route('admin.api.setting')}}">Callback & Token</a></li>
                                    @endcanany
                                @endif
                                <li><a href="javascript:void()">Operator Code </a></li>
                            </ul>
                        </li>
                    @endcanany
                @endif --}}

                @if (checkRecordHasPermission(['aepsservice']))
                    @can('aepsservice')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="uil-cog"></i>
                                <span style="color: #0a1d56;">AEPS Service</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.aeps.system') }}">
                                        <span style="color: #0a1d56;">AEPS</span>
                                    </a></li>
                            </ul>
                        @endcanany
                    </li>
                @endif
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-cog"></i>
                        <span style="color: #0a1d56;">Portal Setting</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a style="color: #0a1d56;" href="javascript:void()">Login OTP</a></li>
                        <li><a style="color: #0a1d56;" href="javascript:void()">Wallect Lock</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-exchange"></i>
                        <span style="color: #0a1d56;">DMT</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a style="color: #0a1d56;" href="{{ route('admin.domestic.money.transfer.recipient.list') }}">Recipient List</a></li>
                        <li><a style="color: #0a1d56;" href="javascript:void()">Money Transfer</a></li>
                    </ul>
                </li>

                <li>
                    <a style="color: #0a1d56;" href="{{ route('admin.logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        {{-- <span class="badge rounded-pill bg-primary float-end">01</span> --}}
                        <span style="color: #0a1d56;">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
