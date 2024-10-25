<div>
    <div wire:loading class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="row mb-2">
                                <!-- Date Filters -->
                                <div class="col-md-2">
                                    <div class="form-group mb-10">
                                        <input type="text"
                                            class="form-control start-date startdate rounded bg-light border-0 start_date"
                                            placeholder="Start Date" id="datepicker-basic" wire:model.live='start_date'>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <input type="text"
                                        class="form-control start-date startdate rounded bg-light border-0 end_date"
                                        placeholder="End Date" id="datepicker-basic" wire:model.live='end_date'>
                                </div>

                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control rounded bg-light border-0"
                                            placeholder="User Id" wire:model.live='agentId'>
                                    </div>
                                </div>

                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control rounded bg-light border-0"
                                            placeholder="QR Code Id" wire:model.live='value'>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <select class="form-control  rounded bg-light border-0"
                                            wire:model.live="status">
                                            <option value="">Status</option>
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}">{!! $status->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-10">
                                    <div class="row">
                                        <div class="col-md-12  d-flex justify-content-center">
                                            <div class="mb-3 d-flex">
                                                <a href="javascript:void(0);"
                                                    class="btn  waves-effect waves-light align-self-center"
                                                    style="background-color:#FE7A36;font-color:white"
                                                    wire:click.prevent='export'><i
                                                        class="fas fa-file-excel me-2"></i>Export</a>
                                            </div>
                                            <div class="mb-3 ms-3 d-flex">
                                                @can('qr-request-add-fund')
                                                <a href="javascript:void(0);"
                                                class="btn btn-success d-flex align-items-center justify-content-center rounded-circle"
                                                style="width: 40px; height: 40px; padding: 0; font-size: 20px; line-height: 1;" wire:click.prevent='walletLoad'><i class="mdi mdi-plus"></i></a>
                                                @endcan
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
                                    @if (auth()->user()->getRoleNames()->first() == 'super-admin')
                                        <th scope="col">User Name</th>
                                    @endif
                                    <th scope="col">QR Id</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Received Amount</th>
                                    <th scope="col">Payment Details</th>
                                    <th scope="col">QR Current Status</th>
                                    <th scope="col">QR Close Reason</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($qr_collection as $key => $item)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                <label class="form-check-label"
                                                    for="contacusercheck1">{{ $loop->iteration }}</label>
                                            </div>
                                        </th>
                                        @if (auth()->user()->getRoleNames()->first() == 'super-admin')
                                            <td>
                                                <a href="javascript:void(0)" class="text-body">{{ $item->user->name }}</a>
                                            </td>
                                        @endif
                                        
                                        <td>
                                            {{ ($item->qr_code_id) }}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($item->payment_amount)}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($item->payments_amount_received)}}
                                        </td>
                                        
                                        <td>
                                            Payment Id:-{{$item->payment_id}} <br> UPI Id:-{{$item->payer_name}} <br>
                                            UTR Number :-{{$item->utr_number}}
                                        </td>
                                        <td>
                                            {{ ucfirst($item->qr_status) }}
                                        </td>
                                        <td>
                                            {{ ucfirst($item->close_reason )}}
                                        </td>
                                        <td>
                                            {{$item->created_at}}
                                        </td>
                                        <td>
                                            {!! $item->status->name !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 100 of {{ $qr_collection->total() }} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($qr_collection->hasPages())
                            <div class="float-sm-end">
                                <ul class="pagination mb-sm-0">
                                    @if ($qr_collection->onFirstPage())
                                        <li class="page-item disabled">
                                            <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item" wire:click="previousPage">
                                            <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                        </li>
                                    @endif

                                    @if ($qr_collection->currentPage() > 3)
                                        <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                            <a href="javascript:void(0)" class="page-link">1</a>
                                        </li>
                                    @endif

                                    @if ($qr_collection->currentPage() > 4)
                                        <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                            <a href="javascript:void(0)" class="page-link">....</a>
                                        </li>
                                    @endif

                                    @foreach (range(1, $qr_collection->lastPage()) as $i)
                                        @if ($i >= $qr_collection->currentPage() - 2 && $i <= $qr_collection->currentPage())
                                            <li class="page-item @if ($qr_collection->currentPage() == $i) active @endif"
                                                wire:click="gotoPage({{ $i }})">
                                                <a href="javascript:void(0)" class="page-link">{{ $i }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    @if ($qr_collection->currentPage() < $qr_collection->lastPage() - 3)
                                        <li class="page-item">
                                            <a href="javascript:void(0)" class="page-link">....</a>
                                        </li>
                                    @endif

                                    @if ($qr_collection->currentPage() < $qr_collection->lastPage() - 2)
                                        <li class="page-item" wire:click="gotoPage({{ $qr_collection->lastPage() }})">
                                            <a href="javascript:void(0)" class="page-link">{{ $qr_collection->lastPage() }}</a>
                                        </li>
                                    @endif

                                    @if ($qr_collection->hasMorePages())
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

    @include('admin.razorpay.razorpay')
</div>
