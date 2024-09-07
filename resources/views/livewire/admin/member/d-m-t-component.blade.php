<div>
    <div wire:loading class="loading"></div>
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
                                        {{-- @can('') --}}
                                            <a href="javascript:void(0);"
                                                class="btn btn-success waves-effect waves-light align-self-center"
                                                wire:click.prevent='create'><i class="mdi mdi-plus me-2"></i> Add New</a>
                                        {{-- @endcan --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check font-size-16">
                                            <label class="form-check-label" for="contacusercheck">Sr No.</label>
                                        </div>
                                    </th>
                                    <th scope="col">Id</th>
                                    <th scope="col">Mobile no.</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Large modal example -->
    {{-- @if ($) --}}
    <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="store" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">DMT</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">DMT</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">

                                    <div class="col-md-6 mb-0">
                                        <label for="mobile_number" class="form-label">Mobile Number</label>
                                        <input type="text" id="mobile_number"
                                            class="form-control @error('mobile_number') is-invalid @enderror"
                                            placeholder="Enter Mobile Number" wire:model.defer='mobile_number' />
                                        @error('mobile_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-0">
                                        <label for="otp" class="form-label">OTP</label>
                                        <input type="text" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Enter OTP" wire:model.defer='otp' />
                                        @error('otp')
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
                </div>
            </form>
        </div>
    </div>
    {{-- @endif --}}
    <!-- end row -->
    @include('admin.delete-confirmation.delete-confirmation')
</div>
