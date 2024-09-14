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
                                        @can('scheme-manager-create')
                                            <a href="javascript:void(0);"
                                            class="btn btn-success d-flex align-items-center justify-content-center rounded-circle"
                                            style="width: 40px; height: 40px; padding: 0; font-size: 20px; line-height: 1;" wire:click.prevent='create'><i class="mdi mdi-plus"></i></a>
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
                                    <th scope="col">Name</th>
                                    @can('scheme-manager-status-change')
                                        <th scope="col">Status</th>
                                    @endcan
                                    @canany(['scheme-manager-edit'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schemes as $key =>$scheme)
                                    @php
                                        $currentPage = $schemes->currentPage() !=1?$schemes->perPage():1;
                                        $srNo  =($schemes->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1">  --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            {{ucfirst($scheme->name)}}
                                        </td>
                                        <td>
                                            @can('scheme-manager-status-change')
                                                <input type="checkbox" id="switch{{$scheme->id}}" switch="bool"  @if($scheme->status==1) checked @endif wire:change='statusUpdate({{$scheme->id}},{{$scheme->status}})' />
                                                <label for="switch{{$scheme->id}}" data-on-label="Active" data-off-label="Inactive"></label>
                                            @endcan
                                        </td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item" wire:click.prevent="edit({{$scheme}})">
                                                    <a href="javascript:void(0);" class="px-2 text-primary"><i class="uil uil-pen font-size-18"></i></a>
                                                </li>
                                                {{-- <li class="list-inline-item">
                                                    <a href="javascript:void(0);" class="px-2 text-danger"><i class="uil uil-trash-alt font-size-18"></i></a>
                                                </li> --}}
                                                <li class="list-inline-item dropdown">
                                                    <a class="text-muted dropdown-toggle font-size-18 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <i class="uil uil-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <div class="menu-header">Commission</div>
                                                        <a class="dropdown-item" href="javascript:void()" wire:click.prevent="getCommission({{$scheme->id}},'mobile')">Mobile Recharge</a>
                                                        <a class="dropdown-item" href="javascript:void()">Virtual Account</a>
                                                        <div class="menu-header">Charge</div>
                                                        <a class="dropdown-item" href="javascript:void()" wire:click.prevent="getCommission({{$scheme->id}},'dmt')">Money Transfer</a>
                                                        <a class="dropdown-item" href="javascript:void()">Virtual Account</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{$schemes->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($schemes->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($schemes->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($schemes->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($schemes->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $schemes->lastPage()) as $i)
                                            @if ($i >=$schemes->currentPage()-2 && $i <=$schemes->currentPage())
                                                <li class="page-item @if($schemes->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($schemes->currentPage() < $schemes->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($schemes->currentPage() < $schemes->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $schemes->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $schemes->lastPage()}}</a>
                                            </li>
                                        @endif
                                        @if($schemes->hasMorePages())
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
    <!--  Large modal example -->
    @if(!$setCommissionForm)
        <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <form wire:submit.prevent='{{$editSchemeForm?"update":"store"}}' autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">{{$editSchemeForm?"Edit":"Add"}} Scheme</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="scheme-name" class="form-label">Scheme Name</label>
                                    <input type="text" id="scheme-name" class="form-control  @error('schemeName') is-invalid @enderror" placeholder="Enter Scheme Name" wire:model.defer='schemeName'/>
                                    @error('schemeName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">{{$editSchemeForm?"Update":"Save"}} changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    @else
        <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <form wire:submit.prevent='storeCommission' autocomplete="off">
                    <input type="hidden" value="{{$operaterName}}" wire:model='operaterType'>
                    <input type="hidden" value="{{$schemeId}}" wire:model='schemeId'>
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">{{$commissionTypeTitle}} Charge</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Operator</th>
                                            <th style="width: 30%;">Commission Type</th>
                                            <th>Commission Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($operaterList as $key => $item)
                                        <tr>
                                            <td>{{ucfirst(Str_replace('-',' to ',$item->name))}}</td>
                                            <input type="hidden" type="hidden" wire:model="items" value="{{ $item->id }}">
                                            <td>
                                                <select wire:model.defer="slab.{{$key}}.type" class="form-control">
                                                    <option value="">Select type</option>
                                                    <option value="0">Percent (%)</option>
                                                    <option value="1">Flat (Rs)</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" id="scheme-name" class="form-control  @error('schemeName') is-invalid @enderror" placeholder="Enter Value" wire:model='slab.{{$key}}.value'>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div>
    @endif

    <!-- end row -->
    @include('admin.delete-confirmation.delete-confirmation')
</div>
