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
                                            placeholder="Transaction Id" wire:model.live='value'>
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

                                    <th scope="col">User Id</th>
                                    <th scope="col">Transaction Id</th>
                                    <th scope="col">Opening Balance</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Closing Balance</th>
                                    <th scope="col">Transaction Type</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction_history as $key => $item)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                <label class="form-check-label"
                                                    for="contacusercheck1">{{ $loop->iteration }}</label>
                                            </div>
                                        </th>
                                        <td>
                                            {{ $item->user->name }}
                                        </td>
                                        <td>
                                            {{ $item->transaction_id }}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($item->opening_amount)}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($item->amount)}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($item->closing_balnce)}}
                                        </td>
                                        <td class="fw-bolder">
                                            <span class="@if($item->transaction_type =='credit') text-success @else text-danger @endif; fw-bolder">  <i class="uil-arrow-down"></i> &#x20B9;{{moneyFormatIndia($item->closing_balnce)}}</span>
                                          
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
                                <p class="mb-sm-0">Showing 1 to 100 of {{ $transaction_history->total() }} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($transaction_history->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($transaction_history->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i
                                                        class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i
                                                        class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif

                                        @if ($transaction_history->currentPage() > 3)
                                            <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif

                                        @if ($transaction_history->currentPage() > 4)
                                            <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif

                                        @foreach (range(1, $transaction_history->lastPage()) as $i)
                                            @if ($i >= $transaction_history->currentPage() - 2 && $i <= $transaction_history->currentPage())
                                                <li class="page-item @if ($transaction_history->currentPage() == $i) active @endif"
                                                    wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)"
                                                        class="page-link">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        @if ($transaction_history->currentPage() < $transaction_history->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif

                                        @if ($transaction_history->currentPage() < $transaction_history->lastPage() - 2)
                                            <li class="page-item"
                                                wire:click="gotoPage({{ $transaction_history->lastPage() }})">
                                                <a href="javascript:void(0)"
                                                    class="page-link">{{ $transaction_history->lastPage() }}</a>
                                            </li>
                                        @endif

                                        @if ($transaction_history->hasMorePages())
                                            <li class="page-item" wire:click="nextPage">
                                                <a href="javascript:void(0)" class="page-link"><i
                                                        class="mdi mdi-chevron-right"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <a href="javascript:void(0)" class="page-link"><i
                                                        class="mdi mdi-chevron-right"></i></a>
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
