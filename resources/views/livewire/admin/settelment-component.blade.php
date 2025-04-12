<div>
    <div wire:loading  class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="card mb-2 bg-transparent shadow-none border-none">



        <div class="card" >
            <div class="card-header   d-flex justify-content-between align-items-center" style="border-bottom: 1px dotted #b2b3b6;
            background:white;">
                <div class="fw-semibold text-muted">Overview</div>

                <div class="select-container">
                    <select class="form-select w-auto" id="overviewSelect" style="border: none; color:red;padding-right:0.75rem;">
                        <option selected>This Week</option>
                        <option>Last Week</option>
                        <option>This Month</option>
                        <option>Last Month</option>
                        <option>Custom Range</option>
                    </select>
                </div>
            </div>

            <div class="card-body">
        <div class="row">

            <!-- Collected Amount -->
            <div class="col-md-3">
                <div class="card" style="background-color:#0a1d56;">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <i class="fas fa-coins text-success fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1 text-white">₹ <span class="counterup">1000</span></h4>
                            <p class="text-white mb-0">Collected Amount</p>
                        </div>
                        <p class="text-white mt-3 mb-0">
                            from  <span class="text-success me-1"><i class=" me-1"></i>24</span> payments
                        </p>
                    </div>
                </div>
            </div>

            <!-- Disputes -->
            <div class="col-md-3">
                <div class="card" style="background-color:#fc0800;">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <i class="fas fa-exclamation-triangle text-light fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1 text-white">₹ <span class="counterup">1000</span></h4>
                            <p class="text-white mb-0">Disputes</p>
                        </div>
                        <p class="text-white mt-3 mb-0">
                            from <span class="text-light me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>5</span>   payments
                        </p>
                    </div>
                </div>
            </div>

            <!-- Refunds -->
            <div class="col-md-3">
                <div class="card" style="background-color:#0a1d56;">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <i class="fas fa-undo text-success fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1 text-white">₹ <span class="counterup">1000</span></h4>
                            <p class="text-white mb-0">Refunds</p>
                        </div>
                        <p class="text-white mt-3 mb-0">
                            <span class="text-light me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>+0%</span> from 8 payments
                        </p>
                    </div>
                </div>
            </div>

            <!-- Failed -->
            <div class="col-md-3">
                <div class="card" style="background-color:#fc0800;">
                    <div class="card-body">
                        <div class="float-end mt-2">
                            <i class="fas fa-times-circle text-light fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 mt-1 text-white">₹ <span class="counterup">1000</span></h4>
                            <p class="text-white mb-0">Failed</p>
                        </div>
                        <p class="text-white mt-3 mb-0">
                            <span class="text-light me-1"><i class="mdi mdi-arrow-up-bold me-1"></i>+0%</span> from 12 payments
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
        </div>

    </div>
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
                                    @if (auth()->user()->getRoleNames()->first() == 'super-admin')
                                        <th scope="col">User Name</th>
                                    @endif
                                    <th scope="col">Settelment Id</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Charges</th>
                                    <th scope="col">Fees</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($settelments as $key =>$settelment)
                                    @php
                                        $currentPage = $settelments->currentPage() !=1?$settelments->perPage():1;
                                        $srNo  =($settelments->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        @if (auth()->user()->getRoleNames()->first() == 'super-admin')
                                        <td>
                                            {{($settelment->user->name)}}
                                        </td>
                                        @endif
                                        <td>
                                            {{($settelment->settelment_id)}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($settelment->amount)}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($settelment->charges)}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($settelment->gst)}}
                                        </td>
                                        <td>
                                            {{$settelment->created_at}}
                                        </td>
                                        <th><span class="badge rounded-pill" style="background-color:#49FF00;">Processed</span></th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{$settelments->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($settelments->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($settelments->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($settelments->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($settelments->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $settelments->lastPage()) as $i)
                                            @if ($i >=$settelments->currentPage()-2 && $i <=$settelments->currentPage())
                                                <li class="page-item @if($settelments->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($settelments->currentPage() < $settelments->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($settelments->currentPage() < $settelments->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $settelments->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $settelments->lastPage()}}</a>
                                            </li>
                                        @endif
                                        @if($settelments->hasMorePages())
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
