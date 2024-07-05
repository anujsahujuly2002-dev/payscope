<div>
    <div wire:loading  class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-lg-12">
            @role(['api-partner','retailer'] )
                <div class="row">
                    @if(auth()->user()->virtual_account_number !='')
                        <div class="col-sm-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-semibold no-margin-top">{{auth()->user()->name}}</h6>
                                            <ul class="list list-unstyled">
                                                <li>Ifsc : <span class="text-semibold"></span>INDB0000235</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-semibold text-right no-margin-top">{{auth()->user()->virtual_account_number}}</h6>
                                            <ul class="list list-unstyled text-right">
                                                <li>Bank Name : <span class="text-semibold">IndusInd Bank</span> </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endrole
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="row mb-2">
                                <div class="col-md-2">
                                    <div class="form-group mb-10">
                                        <input type="text" class="form-control start-date startdate rounded bg-light border-0 start_date" placeholder="Start Date" id="datepicker-basic" wire:model.live='start_date' >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control start-date startdate rounded bg-light border-0 end_date" placeholder="End Date" id="datepicker-basic" wire:model.live='end_date' >
                                </div>
                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control  rounded bg-light border-0" placeholder="UTR No" wire:model.live="value">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control  rounded bg-light border-0" placeholder="Agent Id / Parent Id" wire:model.live='agentId'>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <select class="form-control  rounded bg-light border-0" wire:model.live="status">
                                            <option value="">Status</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{$status->id}}">{!!$status->name!!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3 d-flex">
                                                <a href="javascript:void(0);" class="btn  waves-effect waves-light align-self-center" style="background-color:#FE7A36;font-color:white" wire:click.prevent='export'><i class="fas fa-file-excel me-2"></i>Export</a>
                                            </div>
                                        </div>
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
                                    <th scope="col">id</th>
                                    <th scope="col">Credit Time</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Remitter Details</th>
                                    <th scope="col">Refrence Details</th>
                                    <th scope="col">Opening balance</th>
                                    <th scope="col">Order Amount</th>
                                    <th scope="col">Closing balance</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($virtualRequests as $key =>$virtualRequest)
                                    @php
                                        $currentPage = $virtualRequests->currentPage() !=1?$virtualRequests->perPage():1;
                                        $srNo  =($virtualRequests->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="javascript:void(0)" class="text-body">{{$virtualRequest->id}}</a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-body">{{date('d M y - h:i A', strtotime($virtualRequest->credit_time))}}</a>
                                        </td>
                                        <td>
                                            Name -  {{ucfirst($virtualRequest->user->name)}}<br>Account No:- {{$virtualRequest?->user?->virtual_account_number}}<br>Mobile No - {{$virtualRequest->user->mobile_no}}
                                        </td>
                                        <td>
                                            Remitter Name. -{{ucfirst($virtualRequest->remitter_name)}}<br>Remitter Account No - {{$virtualRequest->remitter_account_number}}<br>Remitter Ifsc code - {{strtoupper($virtualRequest->remitter_ifsc_code)}}
                                        </td>
                                        <td>
                                            Reference Number:-{{$virtualRequest->reference_number}} <br> Remitter Utr :- {{$virtualRequest->remitter_utr}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($virtualRequest->opening_amount)}}
                                        </td>
                                        <td class="fw-bolder">
                                            <span class="text-success fw-bolder"> &#x2B;</span> &#x20B9;{{moneyFormatIndia($virtualRequest->credit_amount)}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($virtualRequest->closing_amount)}}
                                        </td>
                                        <td>
                                            {!!$virtualRequest->status->name!!}
                                        </td>
                                        {{-- @canany(['approved-fund-request'])
                                            <td>
                                                <li class="list-inline-item dropdown">
                                                    <a class="text-muted dropdown-toggle font-size-18 px-2" href="#"
                                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                        <i class="uil uil-ellipsis-v"></i>
                                                    </a>

                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @can('approved-fund-request')
                                                            <a class="dropdown-item" href="javascript:void()"  wire:click.prevent='updateRequest({{$fund}})'>Update Request</a>
                                                        @endcan
                                                    </div>
                                                </li>
                                            </td>
                                        @endcanany --}}
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{$virtualRequests->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($virtualRequests->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($virtualRequests->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($virtualRequests->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($virtualRequests->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $virtualRequests->lastPage()) as $i)
                                            @if ($i >=$virtualRequests->currentPage()-2 && $i <=$virtualRequests->currentPage())
                                                <li class="page-item @if($virtualRequests->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($virtualRequests->currentPage() < $virtualRequests->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($virtualRequests->currentPage() < $virtualRequests->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $virtualRequests->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $virtualRequests->lastPage()}}</a>
                                            </li>
                                        @endif
                                        @if($virtualRequests->hasMorePages())
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
    <!-- end row -->
    @include('admin.delete-confirmation.delete-confirmation')
</div>
