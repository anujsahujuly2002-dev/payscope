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
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
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
                                    <div class="mb-3 d-flex justify-content-center">
                                        @can('create')
                                            <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light align-self-center" wire:click.prevent='create'><i class="mdi mdi-plus me-2"></i> Add New</a>
                                        @endcan
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
                                    <th scope="col">Id</th>
                                    <th scope="col">Recharge Details</th>
                                    <th scope="col">Recharge Amount</th>
                                    <th scope="col">Commission Amount</th>
                                    <th scope="col">Status</th>
                                    {{-- @canany(['permission-edit', 'permission-delete'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($apiPartners as $key =>$apipartner)
                                    @php
                                        $currentPage = $apiPartners->currentPage() !=1?$apiPartners->perPage():1;
                                        $srNo  =($apiPartners->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="javascript:void(0)" class="text-body">{{$apipartner->id}}</a>
                                        </td>
                                        <td>
                                            {{ucfirst($apipartner->name)}}<br>{{$apipartner->apiPartner?->mobile_no}}<br>{{ucfirst($apipartner->getRoleNames()->first())}}
                                        </td>
                                        <td>
                                            {{ucfirst($apipartner?->apiPartner?->parentDetails?->name)}}<br>{{$apipartner?->apiPartner?->parentDetails?->getRoleNames()->first()=='super admin'?'9519035604':$apipartner?->apiPartner?->mobile_no}}<br>{{ucfirst($apipartner?->apiPartner?->parentDetails?->getRoleNames()->first())}}
                                        </td>
                                        <td>
                                            {{ucfirst($apipartner?->apiPartner?->shop_name)}}<br>{{$apipartner?->apiPartner?->website}}
                                        </td>
                                        <td>
                                            {{$apipartner->walletAmount->amount}}
                                        </td>
                                        <td>
                                            {{$apipartner->created_at}}
                                        </td>
                                        <td>
                                            <input type="checkbox" id="switch{{$apipartner->id}}" switch="bool"  @if($apipartner->status==1) checked @endif wire:change='statusUpdate({{$apipartner->id}},{{$apipartner->status}})' />
                                            <label for="switch{{$apipartner->id}}" data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                    </tr>
                                @endforeach --}}

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                {{-- <p class="mb-sm-0">Showing 1 to 10 of {{$apiPartners->total()}} entries</p> --}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            {{-- @if ($apiPartners->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($apiPartners->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($apiPartners->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($apiPartners->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $apiPartners->lastPage()) as $i)
                                            @if ($i >=$apiPartners->currentPage()-2 && $i <=$apiPartners->currentPage()) 
                                                <li class="page-item @if($apiPartners->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($apiPartners->currentPage() < $apiPartners->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($apiPartners->currentPage() < $apiPartners->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $apiPartners->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $apiPartners->lastPage()}}</a>
                                            </li> 
                                        @endif
                                        @if($apiPartners->hasMorePages())
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
                            @endif --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
        <!--  Large modal example -->
        <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <form wire:submit.prevent="StoreApiPartner" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Mobile Recharge</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-md-4 mb-0">
                                    <label for="mobile_number" class="form-label">Mobile Number</label>
                                    <input type="text" id="mobile_number" class="form-control  @error('mobile_number') is-invalid @enderror" placeholder="Enter Mobile Number" wire:model.defer='state.mobile_number'/>
                                    @error('mobile_number')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-0">
                                    <label for="mobile_operator" class="form-label">Mobile Operator</label>
                                    <select name="" id="" class="form-control">
                                        <option value="">Select Mobile Operator</option>
                                        @foreach ($operators as $operator)
                                            <option value="{{$operator->id}}">{{$operator->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('mobile_operator')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-0">
                                    <label for="mobile_number" class="form-label">Operator Circle</label>
                                    <select name="" id="" class="form-control" wire:change="getPlan($event.target.value)">
                                        <option value="">Select Operator Circle</option>
                                    </select>
                                    @error('mobile_number')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-0">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address" wire:model.defer='state.address'/>
                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                
                            </div>
                                
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <!-- end row -->
    @include('admin.delete-confirmation.delete-confirmation')
</div>