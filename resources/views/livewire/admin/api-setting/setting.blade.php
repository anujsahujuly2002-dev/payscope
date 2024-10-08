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
                                                <input type="text" class="form-control rounded bg-light border-0" placeholder="Search...">
                                                <i class="mdi mdi-magnify search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 d-flex justify-content-center">
                                        @can('callback-token-create')
                                        @if (checkRecordHasPermission(['service-create']))
                                            @can('service-create')
                                            <a href="javascript:void(0);"
                                            class="btn btn-success d-flex align-items-center justify-content-center rounded-circle"
                                            style="width: 40px; height: 40px; padding: 0; font-size: 20px; line-height: 1;"
                                            wire:click.prevent='create'>
                                            <i class="mdi mdi-plus"></i>
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="row mb-2">
                        <div class="col-md-2">
                            <div class="form-group mb-10">
                                <input type="text"
                                    class="form-control start-date startdate rounded bg-light border-0 start_date"
                                    placeholder="Start Date" id="datepicker-basic" wire:model.live='start_date'>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="text"
                                class="form-control start-date startdate rounded bg-light border-0 end_date"
                                placeholder="End Date" id="datepicker-basic" wire:model.live='end_date'>
                        </div>
                        <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <input type="text" class="form-control  rounded bg-light border-0"
                                    placeholder="IP Address" wire:model.live="value">
                            </div>
                        </div>
                        <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <input type="text" class="form-control  rounded bg-light border-0"
                                    placeholder="Agent Id" wire:model.live='agentId'>
                            </div>
                        </div>
                        {{-- <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <input type="text" class="form-control  rounded bg-light border-0" placeholder="Api Partner Name" wire:model.live='agentName'>
                            </div>
                        </div> --}}

                        {{-- <div class="col-md-2 mb-10">
                            <div class="form-group">
                                <select class="form-control  rounded bg-light border-0" wire:model.live="status">
                                    <option value="">Status</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{$status->id}}">{!!$status->name!!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-2 mb-10">
                            <div class="mb-3 d-flex justify-content-center">
                                @can('callback-token-create')
                                    <a href="javascript:void(0);"
                                        class="btn btn-success d-flex align-items-center justify-content-center rounded-circle"
                                        style="width: 40px; height: 40px; padding: 0; font-size: 20px; line-height: 1;"
                                        wire:click.prevent='create'><i class="mdi mdi-plus"></i></a>
                                @endcan
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
                                    @role('super-admin')
                                        <th>Api Partner Name</th>
                                    @endrole
                                    <th scope="col">Ip</th>
                                    <th scope="col">Token</th>
                                    <th scope="col">Domain</th>
                                    @canany(['callback-token-delete'])
                                        <th scope="col" style="width: 200px;">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apiTokens as $key => $apiToken)
                                    @php
                                        $currentPage = $apiTokens->currentPage() != 1 ? $apiTokens->perPage() : 1;
                                        $srNo = ($apiTokens->currentPage() - 1) * $currentPage;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                {{-- <input type="checkbox" class="form-check-input" id="contacusercheck1"> --}}
                                                <label class="form-check-label"
                                                    for="contacusercheck1">{{ $srNo + $loop->iteration }}</label>
                                            </div>
                                        </th>
                                        @role('super-admin')
                                            <td>{{ $apiToken->user->name }}</td>
                                        @endrole
                                        <td>
                                            <a href="javascript:void(0)"
                                                class="text-body">{{ $apiToken->ip_address }}</a>
                                        </td>
                                        {{-- <td>
                                            {{$apiToken->ip_address}}
                                        </td> --}}
                                        <td>{{ $apiToken->token }}</td>
                                        <td>{{ $apiToken->domain }}</td>
                                        @canany(['callback-token-delete'])
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    @can('callback-token-delete')
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0);" class="px-2 text-danger"
                                                                wire:click.prevent='deleteConfirmation({{ $apiToken->id }})'><i
                                                                    class="uil uil-trash-alt font-size-18"></i></a>
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
                                <p class="mb-sm-0">Showing 1 to 10 of {{ $apiTokens->total() }} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($apiTokens->hasPages())
                                <div class="float-sm-end">
                                    <ul class="pagination mb-sm-0">
                                        @if ($apiTokens->onFirstPage())
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
                                        @if ($apiTokens->currentPage() > 3)
                                            <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                                <a href="javascript:void(0)" class="page-link">1</a>
                                            </li>
                                        @endif
                                        @if ($apiTokens->currentPage() > 4)
                                            <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @foreach (range(1, $apiTokens->lastPage()) as $i)
                                            @if ($i >= $apiTokens->currentPage() - 2 && $i <= $apiTokens->currentPage())
                                                <li class="page-item @if ($apiTokens->currentPage() == $i) active @endif"
                                                    wire:click="gotoPage({{ $i }})">
                                                    <a href="javascript:void(0)"
                                                        class="page-link">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($apiTokens->currentPage() < $apiTokens->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif
                                        @if ($apiTokens->currentPage() < $apiTokens->lastPage() - 2)
                                            <li class="page-item" wire:click="gotoPage({{ $apiTokens->lastPage() }})">
                                                <a href="javascript:void(0)"
                                                    class="page-link">{{ $apiTokens->lastPage() }}</a>
                                            </li>
                                        @endif
                                        @if ($apiTokens->hasMorePages())
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
    <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="store" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Create Callback & Token</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-6 mb-0">
                                <label for="ip_address" class="form-label">Ip Address</label>
                                <input type="text" id="ip_address"
                                    class="form-control  @error('ip_address') is-invalid @enderror"
                                    placeholder="Enter Ip address" wire:model='state.ip_address' />
                                @error('ip_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-0">
                                <label for="account_number" class="form-label">Webhook Url</label>
                                <input type="text" id="domain"  class="form-control  @error('webhook_url') is-invalid @enderror" placeholder="Enter Webhook Url" wire:model='state.webhook_url' />
                                @error('webhook_url')
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
    </div><!-- /.modal -->
    <!-- end row -->
    @include('admin.delete-confirmation.delete-confirmation')
</div>
