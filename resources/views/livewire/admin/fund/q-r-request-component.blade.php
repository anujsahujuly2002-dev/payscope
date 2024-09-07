<div>
    <div wire:loading class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 d-flex justify-content-end">
                @can('qr-request-add-fund')
                    <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light align-self-end" wire:click.prevent='walletLoad'><i class="mdi mdi-plus me-2"></i>Wallet Load</a>
                @endcan
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="row mb-2">
                                <!-- Date Filters -->
                                <div class="col-md-3">
                                    <div class="form-group mb-10">
                                        <input type="text" class="form-control start-date startdate rounded bg-light border-0 start_date" placeholder="Start Date" id="datepicker-basic" wire:model.live='start_date'>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control start-date startdate rounded bg-light border-0 end_date" placeholder="End Date" id="datepicker-basic" wire:model.live='end_date'>
                                </div>

                                <div class="col-md-3 mb-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control rounded bg-light border-0" placeholder="Order Id" wire:model.live='orderId'>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3 d-flex">
                                                <a href="javascript:void(0);" class="btn waves-effect waves-light align-self-center" style="background-color:#FE7A36;color:white" wire:click.prevent='export'><i class="fas fa-file-excel me-2"></i>Export</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Data Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check font-size-16">
                                            <label class="form-check-label" for="contacusercheck">Sr No.</label>
                                        </div>
                                    </th>
                                    <th scope="col">id</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Order Id</th>
                                    <th scope="col">Opening Amount</th>
                                    <th scope="col">Order Amount</th>
                                    <th scope="col">Closing Amount</th>
                                    {{-- <th scope="col">Remark</th> --}}
                                    <th scope="col">Status</th>
                                    @canany(['approved-qr_request-request'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($qr_requests as $key => $qr_request)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                <label class="form-check-label" for="contacusercheck1">{{ $loop->iteration }}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="javascript:void(0)" class="text-body">{{ $qr_request->id }}</a>
                                        </td>
                                        <td>
                                            {{ ucfirst($qr_request->user->name)}}
                                        </td>
                                        <td>
                                             {{ ucfirst($qr_request->order_id) }}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{ moneyFormatIndia($qr_request->opening_amount) }}
                                        </td>
                                        <td class="fw-bolder">
                                            <span class="text-success fw-bolder"> &#x2B;</span>&#x20B9; {{ moneyFormatIndia($qr_request->order_amount) }}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{ moneyFormatIndia($qr_request->closing_amount) }}
                                        </td>
                                        <td>
                                            {!! $qr_request->status->name !!}
                                        </td>
                                        @canany(['approved-qr_request-request'])
                                            <td>
                                                @if ($qr_request->status->id != '2')
                                                    <li class="list-inline-item dropdown">
                                                        <a class="text-muted dropdown-toggle font-size-18 px-2" href="#"
                                                           role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                            <i class="uil uil-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            @can('approved-fund-request')
                                                                <a class="dropdown-item" href="javascript:void(0)" wire:click.prevent='updateRequest({{ $qr_request }})'>Update Request</a>
                                                            @endcan
                                                        </div>
                                                    </li>
                                                @endif
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{$qr_requests->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                                @if ($qr_requests->hasPages())
                                    <div class="float-sm-end">
                                        <ul class="pagination mb-sm-0">
                                            @if ($qr_requests->onFirstPage())
                                                <li class="page-item disabled">
                                                    <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                                </li>
                                            @else
                                                <li class="page-item" wire:click="previousPage">
                                                    <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                                </li>
                                            @endif
                                            @if ($qr_requests->currentPage()>3)
                                                <li class="page-item" wire:click="gotoPage({{1}})">
                                                    <a href="javascript:void(0)" class="page-link">1</a>
                                                </li>
                                            @endif
                                            @if ($qr_requests->currentPage()>4)
                                                <li class="page-item" wire:click="gotoPage({{1}})">
                                                    <a href="javascript:void(0)" class="page-link">....</a>
                                                </li>
                                            @endif
                                            @foreach (range(1, $qr_requests->lastPage()) as $i)
                                                @if ($i >=$qr_requests->currentPage()-2 && $i <=$qr_requests->currentPage())
                                                    <li class="page-item @if($qr_requests->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                        <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                            @if ($qr_requests->currentPage() < $qr_requests->lastPage() - 3)
                                                <li class="page-item">
                                                    <a href="javascript:void(0)" class="page-link">....</a>
                                                </li>
                                            @endif
                                            @if($qr_requests->currentPage() < $qr_requests->lastPage() - 2)
                                                <li class="page-item"  wire:click="gotoPage({{ $qr_requests->lastPage()}})">
                                                    <a href="javascript:void(0)" class="page-link">{{ $qr_requests->lastPage()}}</a>
                                                </li>
                                            @endif
                                            @if($qr_requests->hasMorePages())
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

    <!-- Large modal example -->
    <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog ">
            <form wire:submit.prevent="makePayment" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Wallet Load Using Qr Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-12 mb-0">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="text" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter Amount" wire:model.defer='payment.amount'/>
                                @error('amount')
                                <div class="invalid-feedback">
                                    {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Pay Now</button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
   
    @include('admin.razorpay.razorpay')
</div>
