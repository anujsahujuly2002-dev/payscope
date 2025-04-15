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
                                        <div class="mb-3 d-flex justify-content-center">
                                        @if (checkRecordHasPermission(['remitter-registration']))
                                            @canany(['remitter-registration'])
                                                <a href="javascript:void(0);" class="btn btn-success d-flex" wire:click.prevent='payerRegistration'><i class="mdi mdi-plus"></i>Payer Registration</a>
                                            @endcanany
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 d-flex justify-content-center">
                                        @if (checkRecordHasPermission(['beneficiary-registration']))
                                            @can('beneficiary-registration')
                                                <a href="javascript:void(0);" class="btn btn-success d-flex" wire:click.prevent='create'><i class="mdi mdi-plus"></i>Beneficiary Registration</a>
                                            @endcan
                                        @endif
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
        {{-- @dd($otpVerificationForm); --}}
        @if ($otpVerificationForm)
            <div class="modal fade" id="form" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog">
                    <form wire:submit.prevent="otpValidate" autocomplete="off">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myLargeModalLabel">OTP Verification</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-md-12 mb-0">
                                        <label for="otp" class="form-label">OTP</label>
                                        <input type="text" id="otp_code" class="form-control @error('otp_code') is-invalid @enderror" placeholder="Enter OTP" wire:model.defer='otp_code' />
                                        @error('otp_code')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </form>
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        @endif
        <!-- end row -->
        @include('admin.delete-confirmation.delete-confirmation')
    </div>
