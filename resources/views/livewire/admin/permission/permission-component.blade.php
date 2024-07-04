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
                                        @can('permssion-create')
                                            <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light align-self-center" wire:click.prevent='addPermission'><i class="mdi mdi-plus me-2"></i> Add New</a>
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
                                    <th scope="col">Permisson Group</th>
                                    <th scope="col">Permission Name</th>
                                    @canany(['permission-edit', 'permission-delete'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $key => $permission)
                                    @php
                                        $currentPage = $permissions->currentPage() !=1?$permissions->perPage():1;
                                        $srNo  =($permissions->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="#" class="text-body">{{ucwords(Str_replace('-',' ',$permission->group))}}</a>
                                        </td>
                                        <td>
                                            {{$permission->name}}
                                        </td>
                                        {{-- <td>SimonRyles@minible.com</td> --}}
                                        @canany(['permission-edit', 'permission-delete'])
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    @can('role-edit')
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0);" class="px-2 text-primary" wire:click.prevent='editPermission({{$permission}})'><i class="uil uil-pen font-size-18"></i></a>
                                                        </li>
                                                    @endcan
                                                    @can('role-delete')
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0);" class="px-2 text-danger" wire:click.prevent='deleteConfirmation({{$permission->id}})'><i class="uil uil-trash-alt font-size-18"></i></a>
                                                        </li>
                                                    @endcan
                                                    {{-- <li class="list-inline-item dropdown">
                                                        <a class="text-muted dropdown-toggle font-size-18 px-2" href="#"
                                                            role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                            <i class="uil uil-ellipsis-v"></i>
                                                        </a>

                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#">Action</a>
                                                            <a class="dropdown-item" href="#">Another action</a>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </li> --}}
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
                                <p class="mb-sm-0">Showing 1 to 10 of {{$permissions->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($permissions->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($permissions->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($permissions->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($permissions->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $permissions->lastPage()) as $i)
                                            @if ($i >=$permissions->currentPage()-2 && $i <=$permissions->currentPage())
                                                <li class="page-item @if($permissions->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($permissions->currentPage() < $permissions->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($permissions->currentPage() < $permissions->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $permissions->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $permissions->lastPage()}}</a>
                                            </li>
                                        @endif
                                        @if($permissions->hasMorePages())
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
                <form wire:submit.prevent="{{$editPermissionForm?'updatePermission':'storePermission'}}" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">{{$editPermissionForm?"Update":"Create"}} Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col mb-0">
                                    <label for="role-name" class="form-label">Permission Group</label>
                                    <input type="text" id="role-name" class="form-control  @error('group') is-invalid @enderror" placeholder="Enter Permission Group" wire:model.defer='state.group'/>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col mb-0">
                                    <label for="role-name" class="form-label">Permission Name</label>
                                    <input type="text" id="role-name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Permission Name" wire:model.defer='state.name'/>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
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
