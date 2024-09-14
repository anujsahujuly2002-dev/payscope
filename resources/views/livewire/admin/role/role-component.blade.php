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
                                        @can('role-create')
                                            <a href="javascript:void(0);"
                                            class="btn btn-success d-flex align-items-center justify-content-center rounded-circle"
                                            style="width: 40px; height: 40px; padding: 0; font-size: 20px; line-height: 1;" wire:click.prevent='createRole'><i class="mdi mdi-plus me-2"></i> Add New</a>
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
                                    <th scope="col">Role Name</th>
                                    <th scope="col">Permission Name</th>
                                    @canany(['role-edit', 'role-delete'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    @php
                                        $currentPage = $roles->currentPage() !=1?$roles->perPage():1;
                                        $srNo  =($roles->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="#" class="text-body">{{ucfirst(Str_replace('-',' ',$role->name))}}</a>
                                        </td>
                                        <td>
                                            @foreach ($role->permissions as $key=> $permissions)
                                                @if(($key+1)%4 == 0)
                                                    <span class="badge rounded-pill bg-secondary">{{ucwords(str_replace('-',' ',$permissions->name))}}</span></br>
                                                @else
                                                    <span class="badge rounded-pill bg-secondary">{{ucwords(str_replace('-',' ',$permissions->name))}}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        @canany(['role-edit', 'role-delete'])
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    @can('role-edit')
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0);" class="px-2 text-primary" wire:click.prevent='editRole({{$role}})'><i class="uil uil-pen font-size-18"></i></a>
                                                        </li>
                                                    @endcan
                                                    @can('role-delete')
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0);" class="px-2 text-danger" wire:click.prevent='deleteConfirmation({{$role->id}})'><i class="uil uil-trash-alt font-size-18"></i></a>
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
                                <p class="mb-sm-0">Showing 1 to 10 of 12 entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-end">
                                <ul class="pagination mb-sm-0">
                                    <li class="page-item disabled">
                                        <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">1</a>
                                    </li>
                                    <li class="page-item active">
                                        <a href="#" class="page-link">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
        <!--  Large modal example -->
        <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <form wire:submit.prevent="{{$editRoleForm?"updateRole":"storeRole"}}" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">{{$editRoleForm?"Update":"Create"}} Role</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="role-name" class="form-label">Role Name</label>
                                    <input type="text" id="role-name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Role Name" wire:model.lazy='name'/>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-4 my-3">
                                @foreach ($permission as $key=> $permissionGroup)
                                    <div class="col-md-6">
                                        <h5 class="font-size-14 mb-3">
                                            <i class="mdi mdi-arrow-right text-primary me-1"></i>{{ ucwords($key) }}
                                        </h5>
                                        <div class="vstack gap-2">
                                            @foreach ($permissionGroup as $key1=> $per)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="formCheck{{$per->id}}"  value="{{ $per->id }}" wire.key="{{ $per->id}}" wire:model.lazy='permissionsId'>
                                                    <label class="form-check-label" for="formCheck{{$per->id}}">
                                                        {{ucwords(str_replace("-"," ",$per->name)) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
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
