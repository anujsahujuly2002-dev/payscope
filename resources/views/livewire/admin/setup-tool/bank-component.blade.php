<div>
    <div><div wire:loading  class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">Manage Bank</h4>
        </div>
        <div class="col-md-6">
            @can('bank-create') 
                <button wire:click.prevent='bankCreate' class="btn btn-primary" style="float: right" >Create Bank</button>
            @endcan
        </div>
    </div>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Bank List</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Bank Name</th>
                        <th>Account Number</th>
                        <th>Ifsc Code</th>
                        <th>Branch Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($banks as $key => $bank)
                        <tr>
                            <td><i class="fab fa-vuejs fa-lg text-success me-3"></i> <strong>{{$loop->iteration}}</strong></td>
                            <td>{{ucfirst(Str_replace('-',' ',$bank->name))}}</td>
                            <td>{{ucfirst(Str_replace('-',' ',$bank->account_number))}}</td>
                            <td>{{ucfirst(Str_replace('-',' ',$bank->ifsc_code))}}</td>
                            <td>{{ucfirst(Str_replace('-',' ',$bank->branch_name))}}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" @if($bank->status==1) checked @endif wire:change='statusUpdate({{$bank->id}},{{$bank->status}})' >
                                    <span class="slider round"></span> 
                                </label>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('role-edit') 
                                        <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='edit({{$bank}})'><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                        @endcan
                                        @can('role-delete')
                                        <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='deleteConfirmation({{$bank->id}})'><i class="bx bx-trash me-2"></i> Delete</a>
                                        @endcan
                                        <div class="loading" wire:loading wire:target='deleteConfirmation'  wire:loading.attr="disabled" ></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- @if ($roles->hasPages())
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if($roles->onFirstPage())
                        <li class="page-item prev">
                            <a class="page-link" href="javascript:void(0);" ><i class="tf-icon bx bx-chevrons-left"></i></a>
                        </li>
                    @else
                        <li class="page-item prev">
                            <a class="page-link" href="javascript:void(0);" wire:click="previousPage" wire:loading.attr="disabled"><i class="tf-icon bx bx-chevrons-left"></i></a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $roles->lastPage(); $i++)
                    @if ($roles->currentPage() == $i)
                        <li class="page-item active" wire:key="paginator-page-{{ $i }}">
                            <a class="page-link" href="javascript:void(0);">{{$i}}</a>
                        </li>
                    @else
                        <li class="page-item " wire:key="paginator-page-{{ $i }}">
                            <a class="page-link" href="javascript:void(0);" wire:click="gotoPage({{ $i }})">{{$i}}</a>
                        </li>
                    @endif
                    
                    @endfor
                    @if (!$roles->onLastPage())
                        <li class="page-item next">
                            <a class="page-link" href="javascript:void(0);" wire:click="nextPage" wire:loading.attr="disabled"><i class="tf-icon bx bx-chevrons-right"></i></a>
                        </li>
                    @else
                        <li class="page-item next">
                            <a class="page-link" href="javascript:void(0);" ><i class="tf-icon bx bx-chevrons-right"></i></a>
                        </li>
                    @endif
                    
                </ul>
            </nav>
        @endif --}}
    </div>
    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-hidden="true" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <form wire:submit.prevent="{{$editBankForm?"updateBank":"storeBank"}}" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formTitle">{{$editBankForm?"Edit":"Create"}} Bank</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-6 mb-0">
                                <label for="name" class="form-label"> Name</label>
                                <input type="text" id="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Bank Name" wire:model.lazy='state.name'/>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="account_number" class="form-label"> Account Number</label>
                                <input type="text" id="account_number" class="form-control  @error('account_number') is-invalid @enderror" placeholder="Enter Account Number" wire:model.lazy='state.account_number'/>
                                @error('account_number')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="ifsc" class="form-label">Ifsc</label>
                                <input type="text" id="ifsc" class="form-control  @error('ifsc_code') is-invalid @enderror" placeholder="Enter Ifsc Code" wire:model.lazy='state.ifsc_code'/>
                                @error('ifsc_code')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="branch_name" class="form-label">Branch</label>
                                <input type="text" id="branch_name" class="form-control  @error('branch_name') is-invalid @enderror" placeholder="Enter Branch" wire:model.lazy='state.branch_name'/>
                                @error('branch_name')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close </button>
                        <button type="submit" class="btn btn-primary" >{{$editBankForm?"Update":"Create"}}</button>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('admin.delete-confirmation.delete-confirmation')
</div>
</div>
