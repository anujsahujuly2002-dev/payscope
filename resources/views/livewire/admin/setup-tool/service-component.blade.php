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
                                            <a href="javascript:void(0);" style="width: 40px; height: 40px; padding: 0; font-size: 20px; line-height: 1;"
                                            class="btn btn-success d-flex align-items-center justify-content-center rounded-circle"
                                            wire:click.prevent='create'><i class="mdi mdi-plus"></i></a>
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
                                    @if (checkRecordHasPermission([ 'service-change-status']))
                                        @canany(['service-change-status'])
                                            <th scope="col">Status</th>
                                        @endcanany
                                    @endif
                                    @if (checkRecordHasPermission([ 'service-edit']))
                                        @canany(['service-edit'])
                                            <th scope="col" style="width: 200px;">Action</th>
                                        @endcanany
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $key => $service)
                                    @php
                                        $currentPage = $services->currentPage() !=1?$services->perPage():1;
                                        $srNo  =($services->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="javascript:void(0)" class="text-body">{{ucfirst(Str_replace('-',' to ',$service->name))}}</a>
                                        </td>
                                        @if (checkRecordHasPermission(['service-change-status']))
                                            @canany(['service-change-status'])
                                                <td>
                                                    <input type="checkbox" id="switch{{$service->id}}" switch="bool"  @if($service->status==1) checked @endif wire:change='statusUpdate({{$service->id}},{{$service->status}})' />
                                                    <label for="switch{{$service->id}}" data-on-label="Active" data-off-label="Inactive"></label>
                                                </td>
                                            @endcanany
                                        @endif
                                       
                                        @if (checkRecordHasPermission(['service-edit']))
                                            @canany(['service-edit'])
                                                <td>
                                                    <ul class="list-inline mb-0">
                                                        @can('service-edit')
                                                            <li class="list-inline-item">
                                                                <a href="javascript:void(0);" class="px-2 text-primary" wire:click.prevent='edit({{$service}})'><i class="uil uil-pen font-size-18"></i></a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </td>
                                            @endcanany
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{$services->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($services->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($services->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($services->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($services->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $services->lastPage()) as $i)
                                            @if ($i >=$services->currentPage()-2 && $i <=$services->currentPage())
                                                <li class="page-item @if($services->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($services->currentPage() < $services->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($services->currentPage() < $services->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $services->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $services->lastPage()}}</a>
                                            </li>
                                        @endif
                                        @if($services->hasMorePages())
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
                            <h5 class="modal-title" id="myLargeModalLabel">{{$editForm?"Edit":"Create"}} Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-md-12 mb-0">
                                    <label for="name" class="form-label"> Name</label>
                                    <input type="text" id="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Service Name" wire:model.lazy='service.name'/>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">{{$editForm?"Update":"Save"}} changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <!-- end row -->
    @include('admin.delete-confirmation.delete-confirmation')
</div>


