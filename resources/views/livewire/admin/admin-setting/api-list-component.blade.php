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
                                        @can('api-create')
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
                                    <th scope="col">Api Name</th>
                                    <th scope="col">Api Code</th>
                                    <th scope="col">Credentials</th>
                                    <th scope="col">Status</th>
                                    @canany(['api-edit'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apiLists as $key => $api)
                                    @php
                                        $currentPage = $apiLists->currentPage() !=1?$apiLists->perPage():1;
                                        $srNo  =($apiLists->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>{{$api->name}}</td>
                                        <td>{{$api->type}}</td>
                                        <td>
                                            <a href="javascript:void()" data-bs-html="true" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-title="{{$api->name}}" data-bs-content="Url :-{{$api->url}} <br>Username:- {{$api->username}} <br> Password :- {{$api->password}} <br> Optional:-{{$api->optional}}">Api Credentials </a>                                        
                                        </td>
                                        <td>
                                            <input type="checkbox" id="switch{{$api->id}}" switch="bool"  @if($api->status==1) checked @endif wire:change='statusUpdate({{$api->id}},{{$api->status}})' />
                                            <label for="switch{{$api->id}}" data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                        @canany(['api-edit'])
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    @can('api-edit')
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0);" class="px-2 text-primary" wire:click.prevent='edit({{$api}})'><i class="uil uil-pen font-size-18"></i></a>
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
                                <p class="mb-sm-0">Showing 1 to 10 of {{$apiLists->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($apiLists->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($apiLists->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($apiLists->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($apiLists->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $apiLists->lastPage()) as $i)
                                            @if ($i >=$apiLists->currentPage()-2 && $i <=$apiLists->currentPage()) 
                                                <li class="page-item @if($apiLists->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($apiLists->currentPage() < $apiLists->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($apiLists->currentPage() < $apiLists->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $apiLists->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $apiLists->lastPage()}}</a>
                                            </li> 
                                        @endif
                                        @if($apiLists->hasMorePages())
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
                <form wire:submit.prevent="{{$editForm?"update":"store"}}" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Api {{$editForm?"Edit":"Create"}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-md-6 mb-0">
                                    <label for="api_name" class="form-label">Api Name</label>
                                    <input type="text" id="api_name" class="form-control  @error('api_name') is-invalid @enderror" placeholder="Enter  Api Name" wire:model='state.api_name'/>
                                    @error('api_name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="api_code" class="form-label">Api Code</label>
                                    <input type="text" id="api_code" class="form-control  @error('api_code') is-invalid @enderror" placeholder="Enter Api Code" wire:model='state.api_code'/>
                                    @error('api_code')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="api_url" class="form-label">Api Url</label>
                                    <input type="text" id="api_url" class="form-control  @error('api_url') is-invalid @enderror" placeholder="Enter Api Url" wire:model='state.api_url'/>
                                    @error('api_url')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="username" class="form-label">User Name</label>
                                    <input type="text" id="username" class="form-control  @error('username') is-invalid @enderror" placeholder="Enter Username" wire:model='state.username'/>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" id="password" class="form-control  @error('password') is-invalid @enderror" placeholder="Enter Password" wire:model='state.password'/>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="optional1" class="form-label">Optional1</label>
                                    <input type="text" id="optional1" class="form-control  @error('optional1') is-invalid @enderror" placeholder="Enter Optional1" wire:model='state.optional1'/>
                                    @error('optional1')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="product_type" class="form-label">Product Type</label>
                                    <select id="product_type" class="form-control @error('product_type') is-invalid @enderror"  wire:model="state.product_type" >
                                        <option value="">Select Type</option>
                                        <option value="recharge">Recharge</option>
                                        <option value="bill">Bill Payment</option>
                                        <option value="money">Money transfer</option>
                                        <option value="pancard">Pancard</option>
                                        <option value="fund">Fund</option>
                                    </select>
                                    @error('product_type')
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