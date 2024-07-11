<div>
    <div wire:loading class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{-- <div class="row mb-2">
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
                                        @can('api-partner-create')
                                            <a href="javascript:void(0);"
                                                class="btn btn-success waves-effect waves-light align-self-center"
                                                wire:click.prevent='createApiPartner'><i class="mdi mdi-plus me-2"></i> Add
                                                New</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <div class="form-group mb-10">
                                <input type="text" class="form-control start-date startdate rounded bg-light border-0 start_date" placeholder="Start Date" id="datepicker-basic" wire:model.live='start_date' >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control start-date startdate rounded bg-light border-0 end_date" placeholder="End Date" id="datepicker-basic" wire:model.live='end_date' >
                        </div>
                        <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <input type="text" class="form-control  rounded bg-light border-0" placeholder="Mobile No." wire:model.live="value">
                            </div>
                        </div>
                        <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <input type="text" class="form-control  rounded bg-light border-0" placeholder="Agent Id / Parent Id" wire:model.live='agentId'>
                            </div>
                        </div>
                        <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <select class="form-control  rounded bg-light border-0" wire:model.live="status">
                                    <option value="">Status</option>
                                    {{-- @foreach ($statuses as $status)
                                        <option value="{{$status->id}}">{!!$status->name!!}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mb-10">
                            <div class="row">
                                <div class="col-md-12  d-flex justify-content-center">
                                    <div class="mb-3 d-flex">
                                        <a href="javascript:void(0);" class="btn  waves-effect waves-light align-self-center" style="background-color:#FE7A36;font-color:white" wire:click.prevent='export'><i class="fas fa-file-excel me-2"></i>Export</a>
                                    </div>
                                    <div class="mb-3 ms-3">
                                        @can('api-partner-create')
                                            <a href="javascript:void(0);"
                                                class="btn btn-success waves-effect waves-light align-self-center"
                                                wire:click.prevent='createApiPartner'><i class="mdi mdi-plus me-2"></i></a>
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
                                    <th scope="col">Id</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Parent Details</th>
                                    <th scope="col">Company Profile</th>
                                    <th scope="col">Wallet Amount</th>
                                    <th scope="col">Locked Amount</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Service</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apiPartners as $key => $apipartner)
                                    @php
                                        $currentPage = $apiPartners->currentPage() != 1 ? $apiPartners->perPage() : 1;
                                        $srNo = ($apiPartners->currentPage() - 1) * $currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label"
                                                    for="contacusercheck1">{{ $srNo + $loop->iteration }}</label>
                                            </div>
                                        </th>
                                        <td>
                                            <a href="javascript:void(0)" class="text-body">{{ $apipartner->id }}</a>
                                        </td>
                                        <td>
                                            {{ ucfirst($apipartner->name) }}<br>{{ $apipartner->apiPartner?->mobile_no }}<br>{{ ucfirst($apipartner->getRoleNames()->first()) }}
                                        </td>
                                        <td>
                                            {{ ucfirst($apipartner?->apiPartner?->parentDetails?->name) }}<br>{{ $apipartner?->apiPartner?->parentDetails?->getRoleNames()->first() == 'super admin' ? '9519035604' : $apipartner?->apiPartner?->mobile_no }}<br>{{ ucfirst($apipartner?->apiPartner?->parentDetails?->getRoleNames()->first()) }}
                                        </td>
                                        <td>
                                            {{ ucfirst($apipartner?->apiPartner?->shop_name) }}<br>{{ $apipartner?->apiPartner?->website }}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{ moneyFormatIndia($apipartner->walletAmount->amount) }}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{ moneyFormatIndia($apipartner->walletAmount->locked_amuont) }}
                                        </td>
                                        <td>
                                            {{ $apipartner->created_at }}
                                        </td>
                                        <td>
                                            <input type="checkbox" id="switch{{ $apipartner->id }}" switch="bool"
                                                @if ($apipartner->status == 1) checked @endif
                                                wire:change='statusUpdate({{ $apipartner->id }},{{ $apipartner->status }})' />
                                            <label for="switch{{ $apipartner->id }}" data-on-label="Active"
                                                data-off-label="Inactive"></label>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="switch_{{ $apipartner->id }}" switch="bool"
                                                @if ($apipartner->services == 1) checked @endif
                                                wire:change='serviceUpdate({{ $apipartner->id }},{{ $apipartner->services }})' />
                                            <label for="switch_{{ $apipartner->id }}" data-on-label="Active"
                                                data-off-label="Inactive"></label>
                                        </td>
                                        <td>
                                            <li class="list-inline-item dropdown">
                                                <a class="text-muted dropdown-toggle font-size-18 px-2"
                                                    href="javascript:void(0)" role="button" data-bs-toggle="dropdown"
                                                    aria-haspopup="true">
                                                    <i class="uil uil-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0)"  wire:click="assignPermissionUserBassed({{ $apipartner->id }})">Permission</a>
                                                    {{-- @if (checkRecordHasPermission(['view-profile']))
                                                    @can('view-profile') --}}
                                                    <a class="dropdown-item"  href="{{ route('admin.view.profile', base64_encode($apipartner->id)) }}">Profile</a>
                                                    {{-- @endcan
                                                    @endif --}}
                                                    <a class="dropdown-item" href="javascript:void(0)" wire:click="changeScheme({{ $apipartner->id }},'dmt')">Scheme</a>
                                                </div>
                                            </li>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 10 of {{ $apiPartners->total() }} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($apiPartners->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($apiPartners->onFirstPage())
                                            <li class="page-item disabled">
                                                <a href="javascript:void()" class="page-link"><i
                                                        class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i
                                                        class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @endif
                                        @if ($apiPartners->currentPage() > 3)
                                            <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($apiPartners->currentPage() > 4)
                                            <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $apiPartners->lastPage()) as $i)
                                            @if ($i >= $apiPartners->currentPage() - 2 && $i <= $apiPartners->currentPage())
                                                <li class="page-item @if ($apiPartners->currentPage() == $i) active @endif"
                                                    wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)"
                                                        class="page-link">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($apiPartners->currentPage() < $apiPartners->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if ($apiPartners->currentPage() < $apiPartners->lastPage() - 2)
                                            <li class="page-item"
                                                wire:click="gotoPage({{ $apiPartners->lastPage() }})">
                                                <a href="javascript:void(0)"
                                                    class="page-link">{{ $apiPartners->lastPage() }}</a>
                                            </li>
                                        @endif
                                        @if ($apiPartners->hasMorePages())
                                            <li class="page-item" wire:click="nextPage">
                                                <a href="javascript:void(0)" class="page-link"><i
                                                        class="mdi mdi-chevron-right"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <a href="javascript:void(0)" class="page-link"><i
                                                        class="mdi mdi-chevron-right"></i></a>
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
    @if ($createApiPartnerForm)
        <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <form wire:submit.prevent="StoreApiPartner" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Create Api Partner</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Personal Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-md-4 mb-0">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id="name"
                                                class="form-control  @error('name') is-invalid @enderror"
                                                placeholder="Enter Name" wire:model.defer='state.name' />
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="email" class="form-label">Email Id</label>
                                            <input type="text" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Enter Email Id" wire:model.defer='state.email' />
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="mobile_number" class="form-label">Mobile Number</label>
                                            <input type="text" id="mobile_number"
                                                class="form-control @error('mobile_number') is-invalid @enderror"
                                                placeholder="Enter Mobile Number"
                                                wire:model.defer='state.mobile_number' />
                                            @error('mobile_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-0">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" id="address"
                                                class="form-control @error('address') is-invalid @enderror"
                                                placeholder="Enter Address" wire:model.defer='state.address' />
                                            @error('address')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="state" class="form-label">State</label>
                                            <select id="state_name"
                                                class="form-control @error('state_name') is-invalid @enderror"
                                                placeholder="Enter State" wire:model.lazy='state.state_name'>
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}">{{ ucfirst($state->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('state_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" id="city"
                                                class="form-control @error('city') is-invalid @enderror"
                                                placeholder="Enter City" wire:model.defer='state.city' />
                                            @error('city')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="pincode" class="form-label">Pincode</label>
                                            <input type="text" id="pincode"
                                                class="form-control @error('pincode') is-invalid @enderror"
                                                placeholder="Enter Pincode" wire:model.defer='state.pincode' />
                                            @error('pincode')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"> Buisness Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-0">
                                            <label for="shop_name" class="form-label">Shop Name</label>
                                            <input type="text" id="shop_name"
                                                class="form-control @error('shop_name') is-invalid @enderror"
                                                placeholder="Enter Shop Name" wire:model.defer='state.shop_name' />
                                            @error('shop_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="pancard_number" class="form-label">Pancard Number</label>
                                            <input type="text" id="pancard_number"
                                                class="form-control @error('pancard_number') is-invalid @enderror"
                                                placeholder="Enter Pancard Number"
                                                wire:model.defer='state.pancard_number' />
                                            @error('pancard_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0">
                                            <label for="adhaarcard_number" class="form-label">AdhaarCard
                                                Number</label>
                                            <input type="text" id="adhaarcard_number"
                                                class="form-control @error('adhaarcard_number') is-invalid @enderror"
                                                placeholder="Enter Adhaar Card Number"
                                                wire:model.defer='state.adhaarcard_number' />
                                            @error('adhaarcard_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0 mt-2">
                                            <label for="scheme" class="form-label">Scheme</label>
                                            <select type="text" id="scheme"
                                                class="form-control @error('scheme') is-invalid @enderror"
                                                wire:model.defer='state.scheme'>
                                                <option value="">Select Scheme</option>
                                                @foreach ($schemes as $scheme)
                                                    <option value="{{ $scheme->id }}">{{ $scheme->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('scheme')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-0 mt-2">
                                            <label for="website" class="form-label">Website</label>
                                            <input type="text" id="website"
                                                class="form-control @error('website') is-invalid @enderror"
                                                placeholder="Enter Website" wire:model.defer='state.website' />
                                            @error('website')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
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
    @elseif($assignPermissionUserBasedForm)
        <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <form wire:submit.prevent="userBasedSyncPermission" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Change Permission</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Permission Group</th>
                                            <th style="width: 60%;">Permission Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permission as $keys => $permissions)
                                            <tr>
                                                <td>{{ ucfirst($keys) }}</td>
                                                <td>
                                                    <div class="vstack gap-2">
                                                        @foreach ($permissions as $key1 => $per)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="formCheck{{ $per->id }}"
                                                                    value="{{ $per->id }}"
                                                                    wire.key="{{ $per->id }}"
                                                                    wire:model.lazy='permissionsId'>
                                                                <label class="form-check-label"
                                                                    for="formCheck{{ $per->id }}">
                                                                    {{ ucfirst(str_replace('-', ' ', $per->name)) }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
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
    @else
        <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <form wire:submit.prevent="setScheme" autocomplete="off">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Change Scheme</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-0 mt-2">
                                    <label for="scheme" class="form-label">Scheme</label>
                                    <select type="text" id="scheme"
                                        class="form-control @error('scheme') is-invalid @enderror"
                                        wire:model.defer='scheme'>
                                        <option value="">Select Scheme</option>
                                        @foreach ($schemes as $scheme)
                                            <option value="{{ $scheme->id }}">{{ $scheme->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('scheme')
                                        <div class="invalid-feedback">
                                            {{ $message }}
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
        </div>
    @endif
    <!-- end row -->
    @include('admin.delete-confirmation.delete-confirmation')
</div>
