<div>
    <div wire:loading  class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{-- <div class="row mb-2">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-inline float-md-end mb-3">
                                        <div class="search-box ms-2">
                                            <div class="position-relative">
                                                <input type="text" class="form-control rounded bg-light border-0"
                                                    placeholder="Search...">
                                                <i class="mdi mdi-magnify search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <div class="form-group mb-10">
                                <input type="text" class="form-control start-date startdate rounded bg-light border-0 start_date" placeholder="Start Date" id="datepicker-basic" wire:model.live='start_date' >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control start-date startdate rounded bg-light border-0 end_date" placeholder="End Date" id="datepicker-basic" wire:model.live='end_date' >
                        </div>
                        {{-- <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <input type="text" class="form-control  rounded bg-light border-0" placeholder="Merchant Name" wire:model.live='value'>
                            </div>
                        </div> --}}
                        <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <input type="text" class="form-control  rounded bg-light border-0" placeholder="IP Address" wire:model.live="value">
                            </div>
                        </div>
                        {{-- <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <input type="text" class="form-control  rounded bg-light border-0" placeholder="Name" wire:model.live="userName">
                            </div>
                        </div> --}}
                        <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <input type="text" class="form-control  rounded bg-light border-0" placeholder="Agent Id" wire:model.live='agentId'>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check font-size-16">
                                            {{-- <input type="checkbox" class="form-check-input" id="contacusercheck"> --}}
                                            <label class="form-check-label" for="contacusercheck">Sr No.</label>
                                        </div>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Latitude</th>
                                    <th scope="col">Logitude</th>
                                    <th scope="col">IP Address</th>
                                    <th scope="col">Login Time</th>
                                    <th scope="col">Is Logged In</th>
                                    <th scope="col">Logout Time</th>
                                    {{-- @canany(['permission-edit', 'permission-delete'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loginSessions as $key =>$loginSession)
                                    @php
                                        $currentPage = $loginSessions->currentPage() !=1?$loginSessions->perPage():1;
                                        $srNo  =($loginSessions->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1">  --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            {{ucfirst($loginSession->user->name)}}
                                        </td>
                                        <td>
                                            {{$loginSession->latitude}}
                                        </td>
                                        <td>
                                            {{$loginSession->logitude}}
                                        </td>
                                        <td>
                                            {{$loginSession->ip_address}}
                                        </td>
                                        <td>
                                            {{$loginSession->login_time}}
                                        </td>
                                        <td>
                                            {{$loginSession->is_logged_in ==0?"Login":"Logout"}}
                                        </td>
                                        <td>
                                            {{$loginSession->logout_time}}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{$loginSessions->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($loginSessions->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($loginSessions->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($loginSessions->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($loginSessions->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $loginSessions->lastPage()) as $i)
                                            @if ($i >=$loginSessions->currentPage()-2 && $i <=$loginSessions->currentPage())
                                                <li class="page-item @if($loginSessions->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($loginSessions->currentPage() < $loginSessions->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($loginSessions->currentPage() < $loginSessions->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $loginSessions->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $loginSessions->lastPage()}}</a>
                                            </li>
                                        @endif
                                        @if($loginSessions->hasMorePages())
                                            <li class="page-item" wire:click="nextPage">
                                                <a href="javascript:void(0)" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <a href="javascript:void(0)" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
