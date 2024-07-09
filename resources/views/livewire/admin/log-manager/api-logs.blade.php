<div>
    <div wire:loading  class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-10">
                                        <input type="text" class="form-control start-date startdate rounded bg-light border-0 start_date" placeholder="Start Date" id="datepicker-basic" wire:model.live='start_date' >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-10">
                                        <input type="text" class="form-control start-date startdate rounded bg-light border-0 end_date" placeholder="End Date" id="datepicker-basic" wire:model.live='end_date' >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control  rounded bg-light border-0" placeholder="Transaction Id" wire:model.live="transaction_id">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);" class="btn  waves-effect waves-light align-self-center" style="background-color:#FE7A36;font-color:white" wire:click.prevent='export'><i class="fas fa-file-excel me-2"></i>Export</a>
                                    </div>
                                </div>
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
                                    <th scope="col">Url</th>
                                    <th scope="col">Transaction Id</th>
                                    <th scope="col">Header</th>
                                    <th scope="col">Request</th>
                                    <th scope="col">Response</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apiLogs as $key =>$apiLog)
                                    @php
                                        $currentPage = $apiLogs->currentPage() !=1?$apiLogs->perPage():1;
                                        $srNo  =($apiLogs->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            {{($apiLog->url)}}
                                        </td>
                                        <td>
                                            {{($apiLog->txn_id)}}
                                        </td>
                                        <td>
                                            {{($apiLog->header)}}
                                        </td>
                                        <td>
                                            {{$apiLog->request}}
                                        </td>
                                        <td>
                                            {{$apiLog->response}}
                                        </td>
                                        {{-- <td>
                                            {{$loginSession->login_time}}
                                        </td>
                                        <td>
                                            {{$loginSession->is_logged_in ==0?"Login":"Logout"}}
                                        </td>
                                        <td>
                                            {{$loginSession->logout_time}}
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{$apiLogs->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($apiLogs->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($apiLogs->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($apiLogs->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($apiLogs->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $apiLogs->lastPage()) as $i)
                                            @if ($i >=$apiLogs->currentPage()-2 && $i <=$apiLogs->currentPage())
                                                <li class="page-item @if($apiLogs->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($apiLogs->currentPage() < $apiLogs->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($apiLogs->currentPage() < $apiLogs->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $apiLogs->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $apiLogs->lastPage()}}</a>
                                            </li>
                                        @endif
                                        @if($apiLogs->hasMorePages())
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
