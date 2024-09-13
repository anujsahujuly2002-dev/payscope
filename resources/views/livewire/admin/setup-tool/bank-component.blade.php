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
<<<<<<< HEAD
                                            <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light align-self-center" wire:click.prevent='bankCreate'><i class="mdi mdi-plus me-2"></i> Add New</a>
=======
                                            <a href="javascript:void(0);"  style="width: 40px; height: 40px; padding: 0; font-size: 20px; line-height: 1;"
                                            class="btn btn-success d-flex align-items-center justify-content-center rounded-circle"
                                            wire:click.prevent='bankCreate'><i class="mdi mdi-plus "></i></a>
>>>>>>> dca90cd8db11dc302b67d1f9c0cac6cc2981b29a
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
                                    <th scope="col">Bank Name</th>
                                    <th scope="col">Account Number</th>
                                    <th scope="col">Ifsc Code</th>
                                    <th scope="col">Branch Name</th>
                                    <th scope="col">Status</th>
                                    @canany(['bank-edit', 'bank-delete'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banks as $key => $bank)
                                    @php
                                        $currentPage = $banks->currentPage() !=1?$banks->perPage():1;
                                        $srNo  =($banks->currentPage()-1)*$currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label" for="contacusercheck1">{{$srNo+$loop->iteration}}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="javascript:void(0)" class="text-body">{{ucfirst(Str_replace('-',' ',$bank->name))}}</a>
                                        </td>
                                        <td>
                                            {{ucfirst(Str_replace('-',' ',$bank->account_number))}}
                                        </td>
                                        <td>{{ucfirst(Str_replace('-',' ',$bank->ifsc_code))}}</td>
                                        <td>{{ucfirst(Str_replace('-',' ',$bank->branch_name))}}</td>
                                        <td>
                                            <input type="checkbox" id="switch{{$bank->id}}" switch="bool"  @if($bank->status==1) checked @endif wire:change='statusUpdate({{$bank->id}},{{$bank->status}})' />
                                            <label for="switch{{$bank->id}}" data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                        {{-- <td>SimonRyles@minible.com</td> --}}
                                        @canany(['bank-edit', 'bank-delete'])
                                            <td>
                                                <ul class="list-inline mb-0">
<<<<<<< HEAD
                                                    @can('bank-edit') 
=======
                                                    @can('bank-edit')
>>>>>>> dca90cd8db11dc302b67d1f9c0cac6cc2981b29a
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0);" class="px-2 text-primary" wire:click.prevent='edit({{$bank}})'><i class="uil uil-pen font-size-18"></i></a>
                                                        </li>
                                                    @endcan
                                                    @can('bank-delete')
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0);" class="px-2 text-danger" wire:click.prevent='deleteConfirmation({{$bank->id}})'><i class="uil uil-trash-alt font-size-18"></i></a>
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
                                <p class="mb-sm-0">Showing 1 to 10 of {{$banks->total()}} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($banks->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($banks->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($banks->currentPage()>3)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($banks->currentPage()>4)
                                            <li class="page-item" wire:click="gotoPage({{1}})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $banks->lastPage()) as $i)
<<<<<<< HEAD
                                            @if ($i >=$banks->currentPage()-2 && $i <=$banks->currentPage()) 
=======
                                            @if ($i >=$banks->currentPage()-2 && $i <=$banks->currentPage())
>>>>>>> dca90cd8db11dc302b67d1f9c0cac6cc2981b29a
                                                <li class="page-item @if($banks->currentPage() ==$i) active @endif"  wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)" class="page-link">{{$i}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($banks->currentPage() < $banks->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if($banks->currentPage() < $banks->lastPage() - 2)
                                            <li class="page-item"  wire:click="gotoPage({{ $banks->lastPage()}})">
                                                <a href="javascript:void(0)" class="page-link">{{ $banks->lastPage()}}</a>
<<<<<<< HEAD
                                            </li> 
=======
                                            </li>
>>>>>>> dca90cd8db11dc302b67d1f9c0cac6cc2981b29a
                                        @endif
                                        @if($banks->hasMorePages())
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
                <form wire:submit.prevent="{{$editBankForm?'updateBank':'storeBank'}}" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">{{$editBankForm?"Update":"Create"}} Bank</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-2">
                                <div class="col-md-6 mb-0">
<<<<<<< HEAD
                                    <label for="name" class="form-label"> Name</label>
=======
                                    <label for="name" class="form-label"> Name<span style="color: red;">*</span></label>
>>>>>>> dca90cd8db11dc302b67d1f9c0cac6cc2981b29a
                                    <input type="text" id="name" class="form-control  @error('name') is-invalid @enderror" placeholder="Enter Bank Name" wire:model.lazy='state.name'/>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
<<<<<<< HEAD
                                    <label for="account_number" class="form-label"> Account Number</label>
=======
                                    <label for="account_number" class="form-label"> Account Number<span style="color: red;">*</span></label>
>>>>>>> dca90cd8db11dc302b67d1f9c0cac6cc2981b29a
                                    <input type="text" id="account_number" class="form-control  @error('account_number') is-invalid @enderror" placeholder="Enter Account Number" wire:model.lazy='state.account_number'/>
                                    @error('account_number')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
<<<<<<< HEAD
                                    <label for="ifsc" class="form-label">Ifsc</label>
=======
                                    <label for="ifsc" class="form-label">Ifsc<span style="color: red;">*</span></label>
>>>>>>> dca90cd8db11dc302b67d1f9c0cac6cc2981b29a
                                    <input type="text" id="ifsc" class="form-control  @error('ifsc_code') is-invalid @enderror" placeholder="Enter Ifsc Code" wire:model.lazy='state.ifsc_code'/>
                                    @error('ifsc_code')
                                        <div class="invalid-feedback">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
<<<<<<< HEAD
                                    <label for="branch_name" class="form-label">Branch</label>
=======
                                    <label for="branch_name" class="form-label">Branch<span style="color: red;">*</span></label>
>>>>>>> dca90cd8db11dc302b67d1f9c0cac6cc2981b29a
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
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <!-- end row -->
    @include('admin.delete-confirmation.delete-confirmation')
<<<<<<< HEAD
</div>
=======
</div>
>>>>>>> dca90cd8db11dc302b67d1f9c0cac6cc2981b29a
