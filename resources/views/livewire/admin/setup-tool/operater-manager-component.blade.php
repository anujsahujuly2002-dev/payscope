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
                                                <input type="text" class="form-control rounded bg-light border-0" placeholder="Search...">
                                                <i class="mdi mdi-magnify search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex justify-content-center">
                                        @can('bank-create')
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
                                            <label class="form-check-label" for="contacusercheck">Sr No.</label>
                                        </div>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Operator Api</th>
                                    <th scope="col">Charge Range</th>
                                    @canany(['operator-edit'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($operatorManagers as $key => $operatorManger)
                                    @php
                                        $currentPage = $operatorManagers->currentPage() !=1?$operatorManagers->perPage():1;
                                        $srNo  =($operatorManagers->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="javascript:void(0)" class="text-body">{{ucfirst(Str_replace('-',' to ',$operatorManger->name))}}</a>
                                        </td>
                                        <td>{{ucfirst(Str_replace('-',' ',$operatorManger->operator_type))}}</td>
                                        <td>
                                            <input type="checkbox" id="switch{{$operatorManger->id}}" switch="bool"  @if($operatorManger->status==1) checked @endif wire:change='statusUpdate({{$operatorManger->id}},{{$operatorManger->status}})' />
                                            <label for="switch{{$operatorManger->id}}" data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                        <td>
                                            {{ucfirst(Str_replace('-',' ',$operatorManger->api->name))}}
                                        </td>
                                        <td>
                                           {{$operatorManger->charge_range}}
                                        </td>
                                        @canany(['operator-edit'])
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    @can('operator-edit') 
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0);" class="px-2 text-primary" wire:click.prevent='edit({{$operatorManger}})'><i class="uil uil-pen font-size-18"></i></a>
                                                        </li>
                                                    @endcan
                                                </ul>
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{$operatorManagers->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($operatorManagers->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($operatorManagers->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($operatorManagers->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($operatorManagers->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $operatorManagers->lastPage()) as $i)
                                            @if ($i >=$operatorManagers->currentPage()-2 && $i <=$operatorManagers->currentPage()) 
                                                <li class="page-item @if($operatorManagers->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($operatorManagers->currentPage() < $operatorManagers->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($operatorManagers->currentPage() < $operatorManagers->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $operatorManagers->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $operatorManagers->lastPage()}}</a>
                                            </li> 
                                        @endif
                                        @if($operatorManagers->hasMorePages())
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
        <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <form wire:submit.prevent="{{$editFormOperaterManger?"update":"store"}}" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">{{$editFormOperaterManger?"Edit":"Create"}} Operator</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-md-6 mb-0">
                                    <label for="name" class="form-label"> Name</label>
                                    <input type="text" id="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Operator Name" wire:model.lazy='operatorLists.name'/>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="operator_type" class="form-label">Operator Type</label>
                                    <select id="operator_type" class="form-control @error('operator_type') is-invalid @enderror" wire:model.defer='operatorLists.operator_type'>
                                        <option value="">Select Operator Type</option>
                                        <option value="mobile">Mobile</option>
                                        <option value="dth">DTH</option>
                                        <option value="electricity">Electricity Bill</option>
                                        <option value="pancard">Pancard</option>
                                        <option value="dmt">Dmt</option>
                                        <option value="aeps">Aeps</option>
                                        <option value="fund">Fund</option>
                                    </select>
                                    @error('operator_type')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="api" class="form-label">Api</label>
                                    <select id="api" class="form-control @error('api_id') is-invalid @enderror" wire:model.defer="operatorLists.api_id">
                                        <option value="">Select Api</option>
                                        @foreach ($apis as $api)
                                            <option value="{{$api->id}}">{{$api->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('api_id')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="name" class="form-label">Charge Range</label>
                                    <input type="text" id="name" class="form-control  @error('charge_range') is-invalid @enderror" placeholder="Enter Charge Range e.g (100-500)" wire:model.lazy='operatorLists.charge_range'/>
                                    @error('charge_range')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">{{$editFormOperaterManger?"Update":"Save"}} changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <!-- end row -->
    @include('admin.delete-confirmation.delete-confirmation')
</div>