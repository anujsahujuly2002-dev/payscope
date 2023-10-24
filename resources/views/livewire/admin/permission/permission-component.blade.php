<div>
    <div wire:loading  class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">Manage Permission</h4>
        </div>
        <div class="col-md-6">
            @can('permssion-create')
            <button wire:click.prevent='addPermission' class="btn btn-primary" style="float: right" >Create
                Permission</button>
            @endcan
        </div>
    </div>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Permission List</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Permisson Group</th>
                        <th>Permission Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($permissions as $key =>$permission)
                    @php
                        $currentPage = $permissions->currentPage() !=1?$permissions->perPage():1;
                        $srNo  =($permissions->currentPage()-1)*$currentPage;
                    @endphp
                        <tr>
                            <td><i class="fab fa-vuejs fa-lg text-success me-3"></i> <strong>{{$srNo+$key+1}}</strong></td>
                            <td>{{ucfirst($permission->group)}}</td>
                            <td>
                                {{$permission->name}}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('permission-edit')
                                            <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='editPermission({{$permission}})'><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                        @endcan
                                        @can('permission-delete')
                                        <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='deleteConfirmation({{$permission->id}})'><i class="bx bx-trash me-2"></i> Delete</a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($permissions->hasPages())
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    @if($permissions->onFirstPage())
                        <li class="page-item prev">
                            <a class="page-link" href="javascript:void(0);" ><i class="tf-icon bx bx-chevrons-left"></i></a>
                        </li>
                    @else
                        <li class="page-item prev">
                            <a class="page-link" href="javascript:void(0);" wire:click="previousPage" wire:loading.attr="disabled"><i class="tf-icon bx bx-chevrons-left"></i></a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $permissions->lastPage(); $i++)
                    @if ($permissions->currentPage() == $i)
                        <li class="page-item active" wire:key="paginator-page-{{ $i }}">
                            <a class="page-link" href="javascript:void(0);">{{$i}}</a>
                        </li>
                    @else
                        <li class="page-item " wire:key="paginator-page-{{ $i }}">
                            <a class="page-link" href="javascript:void(0);" wire:click="gotoPage({{ $i }})">{{$i}}</a>
                        </li>
                    @endif
                    
                    @endfor
                    @if (!$permissions->onLastPage())
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
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-hidden="true" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form wire:submit.prevent="{{$editPermissionForm?"updatePermission":"storePermission"}}" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        @if ($editPermissionForm)
                            <h5 class="modal-title" id="formTitle">Edit Permission</h5>
                        @else
                            <h5 class="modal-title" id="formTitle">Create Permission</h5> 
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="permission-group" class="form-label">Permission Group</label>
                                <input type="text" id="permission-group" class="form-control  @error('group') is-invalid @enderror" placeholder="Enter Permission Group" wire:model.defer='state.group'/>
                            </div>
                            @error('group')
                            <div class="invalid-feedback">
                                {{$message}}
                                </div>
                            @enderror
                            <div class="col mb-0">
                                <label for="name" class="form-label">Permission Name</label>
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Permission Name" wire:model.defer='state.name'/>
                            </div>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close </button>
                        <button type="submit" class="btn btn-primary">{{$editPermissionForm ?"Upadte":'Save'}}</button>
                       
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('admin.delete-confirmation.delete-confirmation')
</div>
