<div><div wire:loading  class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-md-6">
            <h4 class="fw-bold py-3 mb-4">Manage Role</h4>
        </div>
        <div class="col-md-6">
            @can('role-create') 
                <button wire:click.prevent='createRole' class="btn btn-primary" style="float: right" >Create Role</button>
            @endcan
            <div wire:loading wire:target="createRole" class="loading"></div>
        </div>
    </div>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Role List</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Role Name</th>
                        <th>Permission Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($roles as $key => $role)
                        @php
                            $currentPage = $roles->currentPage() !=1?$roles->perPage():1;
                            $srNo  =($roles->currentPage()-1)*$currentPage;
                        @endphp
                        <tr>
                            <td><i class="fab fa-vuejs fa-lg text-success me-3"></i> <strong>{{$srNo+$key+1}}</strong></td>
                            <td>{{ucfirst(Str_replace('-',' ',$role->name))}}</td>
                            <td>
                               @foreach ($role->permissions as $permissions)
                                <span class="badge rounded-pill bg-secondary">{{str_replace('-',' ',$permissions->name)}}</span>
                               @endforeach
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('role-edit') 
                                        <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='editRole({{$role}})'><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                        @endcan
                                        @can('role-delete')
                                        <a class="dropdown-item" href="javascript:void(0);" wire:click.prevent='deleteConfirmation({{$role->id}})'><i class="bx bx-trash me-2"></i> Delete</a>
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
        @if ($roles->hasPages())
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
        @endif
    </div>
    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" aria-hidden="true" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <form wire:submit.prevent="{{$editRoleForm?"updateRole":"storeRole"}}" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formTitle">{{$editRoleForm?"Update":"Create"}} Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for=role-name" class="form-label">Role Name</label>
                                <input type="text" id=role-name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Role Name" wire:model.lazy='name'/>
                            </div>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="row g-2 my-3">
                            @foreach ($permission as $key=> $permissionGroup)
                                <div class="col-md-6 mb-0">
                                    <small class="text-light fw-semibold d-block">{{ ucfirst($key) }}</small>
                                    @foreach ($permissionGroup as $key1=> $per)
                                    <div class="form-check form-check-inline mt-3">
                                        <input class="form-check-input" type="checkbox" wire:model.lazy='permissionsId' value="{{ $per->id }}" wire.key="{{ $per->id}}"  id="per{{ $per->id }}" />
                                        <label class="form-check-label" for="per{{ $per->id }}" style="margin: 0px;">{{ ucfirst(str_replace("-"," ",$per->name)) }}</label>
                                    </div>
                                    @endforeach
                                </div> 
                            @endforeach
                            @error('permissionsId')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close </button>
                        <button type="submit" class="btn btn-primary" >{{$editRoleForm?"Update":"Create"}}</button>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('admin.delete-confirmation.delete-confirmation')
</div>