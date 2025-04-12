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
                                        <input type="text" class="form-control  rounded bg-light border-0" placeholder="Dispute Id /Payment Id" wire:model.live="dispute_id">
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);" class="btn  waves-effect waves-light align-self-center" style="background-color:#FE7A36;font-color:white" wire:click.prevent='export'><i class="fas fa-file-excel me-2"></i>Export</a>
                                    </div>
                                </div> --}}
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
                                    <th scope="col">dispute Id</th>
                                    <th scope="col">Payment Id</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Respond By</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($disputes as $key =>$dispute)
                                    @php
                                        $currentPage = $disputes->currentPage() !=1?$disputes->perPage():1;
                                        $srNo  =($disputes->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            {{($dispute->user->name)}}
                                        </td>
                                        <td class="fw-bolder">
                                            {{($dispute->dispute_id)}}
                                        </td>
                                        <td class="fw-bolder">
                                            {{($dispute->payment_id)}}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{moneyFormatIndia($dispute->amount)}}
                                        </td>
                                        <td class="fw-bolder">{{ucfirst($dispute->phase)}} </td>
                                        <td class="fw-bolder">
                                          {{($dispute->respond_by)}}
                                        </td>
                                        <td>
                                            {{$dispute->created_at_razorpay}}
                                        </td>
                                        <th>
                                            @if ($dispute->status =='open')
                                                <span class="badge rounded-pill" style="background-color:#FE0000;">{{ucwords($dispute->status)}}</span>
                                            @elseif($dispute->status=='won')
                                                <span class="badge rounded-pill bg-success">{{ucwords($dispute->status)}}</span>
                                            @elseif($dispute->status=='lost')
                                                <span class="badge rounded-pill bg-secondary">{{ucwords($dispute->status)}}</span>
                                            @endif
                                        </th>
                                        <td>{{$dispute->reason_code}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{$disputes->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($disputes->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($disputes->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($disputes->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($disputes->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $disputes->lastPage()) as $i)
                                            @if ($i >=$disputes->currentPage()-2 && $i <=$disputes->currentPage())
                                                <li class="page-item @if($disputes->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($disputes->currentPage() < $disputes->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($disputes->currentPage() < $disputes->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $disputes->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $disputes->lastPage()}}</a>
                                            </li>
                                        @endif
                                        @if($disputes->hasMorePages())
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
