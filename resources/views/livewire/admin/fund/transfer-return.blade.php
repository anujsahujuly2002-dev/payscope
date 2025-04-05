<div>
    <div wire:loading class="loading"></div>
    @include('admin.flash-message.flash-message')

    <!-- Stats Card -->
    <div class="card mb-2 bg-transparent shadow-none border-none">


        <div class="row">
            <!-- Total Credits -->
            <div class="col-md-4">
                <div class="stat-card card border-0 shadow-sm hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Credits</h6>
                                <h3 class="mb-0 text-success fw-bold">₹{{ $this->total_credit() }}</h3>
                            </div>
                            <div class="icon-box ">
                                <i class="fas fa-arrow-up text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Debits -->
            <div class="col-md-4">
                <div class="stat-card card border-0 shadow-sm hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Debits</h6>
                                <h3 class="mb-0 text-danger fw-bold">₹{{ $this->total_debit() }}</h3>
                            </div>
                            <div class="icon-box ">
                                <i class="fas fa-arrow-down text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Transactions -->
            <div class="col-md-4">
                <div class="stat-card card border-0 shadow-sm hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Transactions</h6>
                                <h3 class="mb-0 text-primary fw-bold">{{ $this->total_transactions() }}</h3>
                            </div>
                            <div class="icon-box ">
                                <i class="fas fa-exchange-alt text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <!-- Transaction History Card -->
    <div class="card p-4 ">

        <div class="card-body p-0">
            <div class="row py-4">
                <div class="col-md-2">
                    <div class="form-group">
                        {{-- <label class="form-label text-muted">Start Date</label> --}}
                        <input type="date" class="form-control start-date startdate rounded bg-light border-0 start_date" placeholder="Start Date" id="datepicker-basic"
                            wire:model.live="start_date" >
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {{-- <label class="form-label text-muted">End Date</label> --}}
                        <input type="date" class="form-control start-date startdate rounded bg-light border-0 end_date" placeholder="End Date" id="datepicker-basic" wire:model.live="end_date" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {{-- <label class="form-label text-muted">Search User</label> --}}
                        <div class="input-group">

                            <input type="text" class="form-control rounded-end bg-light border-0"
                                placeholder="Name | Email | Mobile" wire:model.live="selectedUserSearch">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {{-- <label class="form-label text-muted">Transaction Type</label> --}}
                        <select class="form-control  rounded bg-light border-0" wire:model.live="transactionFilter">
                            <option value="">All Transactions</option>
                            <option value="1">Only Credited</option>
                            <option value="2">Only Debited</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        {{-- <label class="form-label text-muted">Export</label> --}}
                        <button wire:click='export' class="btn w-100 waves-effect waves-light"
                            style="background-color:#FE7A36;color:rgba(8, 3, 3, 0.533)">
                            <i class="fas fa-file-excel me-1"></i> Export
                        </button>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">

                        @can('transfer-return-new-request')

                        <a type="button"
                            class="btn btn-success d-flex align-items-center justify-content-center rounded-circle"
                            style="width: 40px; height: 40px; padding: 0; font-size: 20px; line-height: 1;"
                             wire:click.prevent='showForm'>
                            <i class="mdi mdi-plus"></i>
                        </a>
                        @endcan
                        <!-- Search User Modal -->
                        <div wire:ignore.self class="modal fade" id="form" tabindex="-1"
                            aria-labelledby="searchUserModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="searchUserModalLabel">Search User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Search Input -->
                                        <div class="mb-4">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                                <input type="text" class="form-control bg-light border-0"
                                                    placeholder="Name|Email|Mobile"
                                                    wire:model.live="value">
                                            </div>
                                        </div>

                                        <!-- Search Results -->
                                        @if (!$selectedUser)
                                            @if ($value && $searchResults->isNotEmpty())
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>User Details</th>
                                                                <th>Contact Information</th>
                                                                <th>Role</th>
                                                                <th class="text-end">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($searchResults as $user)
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-shrink-0">
                                                                                <div class="avatar avatar-sm bg-primary rounded-circle text-white d-flex align-items-center justify-content-center"
                                                                                    style="width: 40px; height: 40px;">
                                                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="ms-2">
                                                                                <h6 class="mb-0">{{ $user->name }}
                                                                                </h6>
                                                                                <small class="text-muted">ID:
                                                                                    #{{ $user->id }}</small>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div>
                                                                            <div><i
                                                                                    class="fas fa-envelope text-muted me-1"></i>
                                                                                {{ $user->email }}</div>
                                                                            <div><i
                                                                                    class="fas fa-phone text-muted me-1"></i>
                                                                                {{ $user->mobile_no }}</div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge bg-soft-primary text-primary">
                                                                            {{ ucfirst($user->getRoleNames()->first() ?? 'User') }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="text-end">
                                                                        <button class="btn btn-sm btn-primary"
                                                                            wire:click="selectUser({{ $user->id }})"
                                                                            onclick="closeModal()">
                                                                            Select User
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @elseif ($value)
                                                <div class="text-center py-4">
                                                    <div class="avatar avatar-lg bg-light-warning d-flex justify-content-center  rounded-circle mb-3" style="width: 100%;">
                                                        <i class="fas fa-user-slash text-warning text-center"></i>
                                                    </div>
                                                    <h6>No Users Found</h6>
                                                    <p class="text-muted">Try searching with different keywords</p>
                                                </div>
                                            @endif
                                        @endif
                                        @if ($selectedUser)
                                            <div class="card bg-transparent shadow-none border-none ">

                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-md bg-primary rounded-circle text-white me-3 d-flex align-items-center justify-content-center"
                                                                style="width: 48px; height: 48px;">
                                                                {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-1">{{ $selectedUser->name }}</h5>
                                                                <div class="text-muted">
                                                                    <i class="fas fa-envelope me-1"></i>
                                                                    {{ $selectedUser->email }} |
                                                                    <i class="fas fa-phone me-1"></i>
                                                                    {{ $selectedUser->mobile_no }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="text-muted mb-1">Available Balance</div>
                                                            <h3 class="text-success mb-0">
                                                                ₹{{ number_format($selectedUser->wallet_balance, 2) }}
                                                            </h3>
                                                        </div>
                                                        <button class="btn btn-icon btn-sm btn-light rounded-circle"
                                                            wire:click="clearUser">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Transaction Process Card -->
                                            <div class="card bg-transparent shadow-none border-none ">
                                                <div class="card-header bg-white py-3">
                                                    <h5 class="mb-0">Process Transaction</h5>
                                                </div>
                                                <div class="card-body">
                                                    <form wire:submit.prevent="processTransaction">
                                                        <div class="row ">
                                                            <!-- Amount -->
                                                            <div class="col-md-4 mb-4">
                                                                <div class="form-group">
                                                                    <label class="form-label">Amount</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text bg-light border-0">₹</span>
                                                                        <input type="number"
                                                                            class="form-control rounded-end bg-light border-0"
                                                                            placeholder="Enter amount"
                                                                            wire:model="amount">
                                                                    </div>
                                                                    @error('amount')
                                                                        <span class="text-danger small">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- Transaction Type -->
                                                            <div class="col-md-4 mb-4">
                                                                <div class="form-group">
                                                                    <label class="form-label">Transaction Type</label>
                                                                    <select class="form-control bg-light border-0"
                                                                        wire:model="transactionType">
                                                                        <option value="">Select Type</option>
                                                                        <option value="1">Transfer (Add Money)</option>
                                                                        <option value="2">Return (Deduct Money)</option>
                                                                    </select>
                                                                    @error('transactionType')
                                                                        <span class="text-danger small">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- Remark -->
                                                            <div class="col-md-4 mb-4">
                                                                <div class="form-group">
                                                                    <label class="form-label">Remark</label>
                                                                    <input type="text"
                                                                        class="form-control bg-light border-0"
                                                                        placeholder="Enter transaction remark"
                                                                        wire:model="remark">
                                                                    @error('remark')
                                                                        <span class="text-danger small">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- UTR Number -->
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="form-label">UTR Number</label>
                                                                    <input type="text"
                                                                        class="form-control bg-light border-0"
                                                                        placeholder="Enter UTR number"
                                                                        wire:model="utr_number">
                                                                    @error('utr_number')
                                                                        <span class="text-danger small">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- Reference Number -->
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="form-label">Reference Number</label>
                                                                    <input type="text"
                                                                        class="form-control bg-light border-0"
                                                                        placeholder="Enter Reference number"
                                                                        wire:model="reference_number">
                                                                    @error('reference_number')
                                                                        <span class="text-danger small">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- Submit Button -->
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label class="form-label">&nbsp;</label>
                                                                    <button type="submit"
                                                                        class="btn w-100 waves-effect waves-light"
                                                                        style="background-color:#FE7A36;color:white">
                                                                        <i class="fas fa-check-circle me-1"></i> Process
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Selected User Card -->







                    </div>
                </div>
            </div>
            <div class="table-responsive " style="overflow-x: auto; white-space: nowrap;">
                <table class="table table-hover mb-0 table-responsive">
                    <thead class="">
                        <tr>

                            <th> Sr.No</th>
                            <th>User Details</th>

                            <th>Date & Time</th>
                            <th>Transaction Type</th>
                            <th>Amount</th>
                            <th>Utr Number</th>
                            <th>Reference Number</th>
                            <th>Transaction Id</th>
                            <th>Remark</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1; @endphp
                        @forelse($transactions as $transaction)
                            <tr>

                                <td>
                                    {{ $count }}
                                    @php $count++; @endphp

                                </td>

                                <td>
                                    {{-- {{$transaction->user_id}} --}}
                                    Name:{{ $this->getUserName($transaction->user_id) }} <br>
                                    Email:{{ $this->getUserEmail($transaction->user_id) }} <br>
                                    Mobile-No:{{ $this->getUserNumber($transaction->user_id) }} <br>

                                </td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y') }}</div>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($transaction->created_at)->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $transaction->transaction_type == '1' ? 'success' : 'danger' }} bg-opacity-10 text-{{ $transaction->transaction_type == '1' ? 'success' : 'danger' }}">
                                        <i
                                            class="fas fa-{{ $transaction->transaction_type == '1' ? 'arrow-up' : 'arrow-down' }} me-1"></i>
                                        {{ $transaction->transaction_type == '1' ? 'Credited' : 'Debited' }}
                                    </span>
                                </td>
                                <td>₹{{ number_format($transaction->amount) }}</td>
                                <td>{{ $transaction->utr_number ?? 'Null' }}</td>
                                <td>{{ $transaction->reference_number ?? 'Null' }}</td>
                                <td>{{ $transaction->transaction_id ?? 'Null' }}</td>
                                <td>{{ $transaction->remark }}</td>
                                <td class="{{ $transaction->status == '2' ? 'text-success' : 'text-danger' }}">
                                    <i
                                        class="fas fa-{{ $transaction->status == '2' ? 'check-circle' : 'times-circle' }} me-1"></i>
                                    Approved
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fas fa-history fa-2x mb-2"></i>
                                    <div>No transactions found</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination Section -->
            <div class="row mt-4">
                <div class="col-sm-6 ">
                    <div>
                        <p class="mb-sm-0">Showing {{ $transactions->firstItem() ?? 0 }} to
                            {{ $transactions->lastItem() ?? 0 }} of
                            {{ $transactions->total() ?? 0 }} entries</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    @if ($transactions->hasPages())
                        <div class="float-sm-end">
                            <ul class="pagination mb-sm-0">
                                @if ($transactions->onFirstPage())
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

                                @if ($transactions->currentPage() > 3)
                                    <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                        <a href="javascript:void(0)" class="page-link">1</a>
                                    </li>
                                @endif

                                @if ($transactions->currentPage() > 4)
                                    <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                        <a href="javascript:void(0)" class="page-link">....</a>
                                    </li>
                                @endif

                                @foreach (range(1, $transactions->lastPage()) as $i)
                                    @if ($i >= $transactions->currentPage() - 2 && $i <= $transactions->currentPage())
                                        <li class="page-item @if ($transactions->currentPage() == $i) active @endif"
                                            wire:click="gotoPage({{ $i }})">
                                            <a href="javascript:void(0)" class="page-link">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                @if ($transactions->currentPage() < $transactions->lastPage() - 3)
                                    <li class="page-item">
                                        <a href="javascript:void(0)" class="page-link">....</a>
                                    </li>
                                @endif

                                @if ($transactions->currentPage() < $transactions->lastPage() - 2)
                                    <li class="page-item" wire:click="gotoPage({{ $transactions->lastPage() }})">
                                        <a href="javascript:void(0)"
                                            class="page-link">{{ $transactions->lastPage() }}</a>
                                    </li>
                                @endif

                                @if ($transactions->hasMorePages())
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
