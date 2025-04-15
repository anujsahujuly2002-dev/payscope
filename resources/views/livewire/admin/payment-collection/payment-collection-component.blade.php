<div>
    <div wire:loading class="loading"></div>
    @include('admin.flash-message.flash-message')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h4 class="fw-bold mb-0">Overview</h4>
                            <h6 class="mb-0 mt-1 ms-4 text-muted">
                                <i class="fa fa-clock me-2"></i>8 min Ago
                            </h6>
                            <button class="btn btn-link text-primary ms-4 p-0 d-flex align-items-center interactive-btn" style="text-decoration: none;" wire:click="" wire:loading.attr="disabled">
                                <i class="mdi mdi-replay"></i>
                                <span class="ms-2">Refresh</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex flex-wrap">
                    <!-- Cards Section -->
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card border-0 shadow-sm h-100 hover-card">
                            <div class="card-body text-center">
                                <p class="text-muted mb-2">Current Balance
                                    <i class="fa fa-info-circle ms-1 text-secondary interactive-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="This is the total amount that is due to be deposited in your bank account after deductions."></i>
                                </p>
                                <h3 class="fw-bold mb-0 text-primary">&#x20B9; {{$currentBalance}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card border-0 shadow-sm h-100 hover-card">
                            <div class="card-body text-center">
                                <p class="text-muted mb-2">Settlement Due Today
                                    <i class="fa fa-info-circle ms-1 text-secondary interactive-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="This is the amount initiated for deposit and is in processing."></i>
                                </p>
                                <h3 class="fw-bold mb-0 text-success">&#x20B9; {{$settelmentDueToday}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card border-0 shadow-sm h-100 hover-card">
                            <div class="card-body text-center">
                                <p class="text-muted mb-2">Previous Settlement
                                    <i class="fa fa-info-circle ms-1 text-secondary interactive-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="This is the last amount initiated for deposit."></i>
                                </p>
                                <h3 class="fw-bold mb-0 text-warning">&#x20B9; {{$previousSettelment}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card border-0 shadow-sm h-100 hover-card">
                            <div class="card-body text-center">
                                <p class="text-muted mb-2">Upcoming Settlement
                                    <i class="fa fa-info-circle ms-1 text-secondary interactive-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="This is the amount that’ll be deposited into your bank account next."></i>
                                </p>
                                <h3 class="fw-bold mb-0 text-info">&#x20B9; {{$upcommingSettelment}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <div class="row mb-2">
                                <!-- Date Filters -->
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
                                        <input type="text" class="form-control rounded bg-light border-0"
                                            placeholder="User Id" wire:model.live='agentId'>
                                    </div>
                                </div>

                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control rounded bg-light border-0"
                                            placeholder="QR Id / Pay Id" wire:model.live='value'>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-10">
                                    <div class="form-group">
                                        <select class="form-control  rounded bg-light border-0"
                                            wire:model.live="status">
                                            <option value="">Status</option>
                                            @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{!! $status->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-10">
                                    <div class="row">
                                        <div class="col-md-12  d-flex justify-content-center">
                                            <div class="mb-3 d-flex">
                                                <a href="javascript:void(0);"
                                                    class="btn  waves-effect waves-light align-self-center"
                                                    style="background-color:#FE7A36;font-color:white"
                                                    wire:click.prevent='export'><i
                                                        class="fas fa-file-excel me-2"></i>Export</a>
                                            </div>
                                            <div class="mb-3 ms-3 d-flex">
                                                @if(checkRecordHasPermission(['qr-collection-add-payment']))
                                                @can('qr-collection-add-payment')
                                                <a href="javascript:void(0);"
                                                    class="btn btn-success d-flex align-items-center justify-content-center rounded-circle"
                                                    style="width: 40px; height: 40px; padding: 0; font-size: 20px; line-height: 1;" wire:click.prevent='initiatePayment()'><i class="mdi mdi-plus"></i></a>
                                                @endcan
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Data Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check font-size-16">
                                            <label class="form-check-label" for="contacusercheck">Sr No.</label>
                                        </div>
                                    </th>
                                    @if (auth()->user()->getRoleNames()->first() == 'super-admin')
                                    <th scope="col">User Name</th>
                                    @endif
                                    <th scope="col">QR Id</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Received Amount</th>
                                    <th scope="col">Payment Details</th>
                                    {{--<th scope="col">QR Current Status</th>
                                    <th scope="col">QR Close Reason</th>--}}
                                    <th scope="col">Created At</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($qr_collection as $key => $item)
                                @php
                                $currentPage = $qr_collection->currentPage() !=1?$qr_collection->perPage():1;
                                $srNo =($qr_collection->currentPage()-1)*$currentPage;
                                @endphp
                                <tr>
                                    <th scope="row">
                                        <div class="form-check font-size-16"> <label class="form-check-label" for="contacusercheck1">{{ $srNo+$loop->iteration }}</label>
                                        </div>
                                    </th>
                                    @if (auth()->user()->getRoleNames()->first() == 'super-admin')
                                    <td>
                                        <a href="javascript:void(0)" class="text-body">{{ $item->user->name }}</a>
                                    </td>
                                    @endif

                                    <td>
                                        {{ ($item->qr_code_id) }}
                                    </td>
                                    <td class="fw-bolder">
                                        &#x20B9;{{moneyFormatIndia($item->payment_amount)}}
                                    </td>
                                    <td class="fw-bolder">
                                        &#x20B9;{{moneyFormatIndia($item->payments_amount_received)}}
                                    </td>

                                    <td>
                                        Payment Id:-{{$item->payment_id}} <br>
                                        {{--UPI Id:-{{$item->payer_name}} <br>--}}
                                        UTR Number :-{{$item->utr_number}}
                                    </td>
                                    {{-- <td>
                                            {{ ucfirst($item->qr_status) }}
                                    </td>
                                    <td>
                                        {{ ucfirst($item->close_reason )}}
                                    </td>--}}
                                    <td>
                                        {{$item->created_at}}
                                    </td>
                                    <td>
                                        {!! $item->status->name !!}
                                    </td>
                                    <td><button class="btn btn-success btn-sm" wire:click.prevent="openPrintSlipModal({{$item->id}},{{$item->user_id}})"><i class="fas fa-print"></i></button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="row mt-4">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">Showing 1 to 100 of {{ $qr_collection->total() }} entries</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if ($qr_collection->hasPages())
                            <div class="float-sm-end">
                                <ul class="pagination mb-sm-0">
                                    @if ($qr_collection->onFirstPage())
                                    <li class="page-item disabled">
                                        <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                    </li>
                                    @else
                                    <li class="page-item" wire:click="previousPage">
                                        <a href="javascript:void()" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                    </li>
                                    @endif

                                    @if ($qr_collection->currentPage() > 3)
                                    <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                        <a href="javascript:void(0)" class="page-link">1</a>
                                    </li>
                                    @endif

                                    @if ($qr_collection->currentPage() > 4)
                                    <li class="page-item" wire:click="gotoPage({{ 1 }})">
                                        <a href="javascript:void(0)" class="page-link">....</a>
                                    </li>
                                    @endif

                                    @foreach (range(1, $qr_collection->lastPage()) as $i)
                                    @if ($i >= $qr_collection->currentPage() - 2 && $i <= $qr_collection->currentPage())
                                        <li class="page-item @if ($qr_collection->currentPage() == $i) active @endif"
                                            wire:click="gotoPage({{ $i }})">
                                            <a href="javascript:void(0)" class="page-link">{{ $i }}</a>
                                        </li>
                                        @endif
                                        @endforeach

                                        @if ($qr_collection->currentPage() < $qr_collection->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                            @endif

                                            @if ($qr_collection->currentPage() < $qr_collection->lastPage() - 2)
                                                <li class="page-item" wire:click="gotoPage({{ $qr_collection->lastPage() }})">
                                                    <a href="javascript:void(0)" class="page-link">{{ $qr_collection->lastPage() }}</a>
                                                </li>
                                                @endif

                                                @if ($qr_collection->hasMorePages())
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
    <!-- Large modal example -->
    @if ($showPaymentModal)
    <div class="modal fade bs-example-modal-lg" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="makePayment" autocomplete="off">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Payment Intiate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-md-4 mb-0">
                                <label for="amount" class="form-label">Name<span style="color: red;">*</span></label>
                                <input type="text" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter Name" wire:model.defer='payment.name' />
                                @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-0">
                                <label for="amount" class="form-label">Email<span style="color: red;">*</span></label>
                                <input type="text" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter Email" wire:model.defer='payment.email' />
                                @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-0">
                                <label for="amount" class="form-label">Mobile No<span style="color: red;">*</span></label>
                                <input type="text" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter mobile no" wire:model.defer='payment.mobile_no' />
                                @error('mobile_no')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-0">
                                <label for="amount" class="form-label">Amount<span style="color: red;">*</span></label>
                                <input type="text" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Enter Amount" wire:model.defer='payment.amount' />
                                @error('amount')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Pay Now</button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div>
    @endif
    <!-- /.modal -->

    <!-- modal for print slip -->
    @if ($transationSlip)
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content receipt-container border-0">
                <div class="modal-footer receipt-header bg-light py-4 justify-content-between no-print">
                </div>

                <div class="modal-body receipt-body p-4" id="print-content" style="max-height: 500px; overflow-y: auto;" wire:ignore>

                    <div class="text-center mb-3">
                        <div class="logo-container">
                            <i class="fas fa-qrcode fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-1" style="color: #182848;">Payment Receipt</h4>
                        <span class="badge bg-light text-primary px-3 py-1">QR Collection Portal</span>
                        <div class="divider mt-2 mb-3"></div>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="field-label"><i class="fas fa-random me-1"></i>User Name</label>
                            <div class="field-value">{{ $users->name ?? 'NULL' }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label"><i class="fas fa-qrcode me-1"></i>QR ID</label>
                            <div class="field-value">{{ $qr_payment_collection->qr_code_id ?? 'NULL'}}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label"><i class="fas fa-rupee-sign me-1"></i>Amount</label>
                            <div class="field-value">₹ {{ $qr_payment_collection->payment_amount ?? 'NULL'}}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label"><i class="fas fa-check-circle me-1"></i>Received Amount</label>
                            <div class="field-value">₹ {{ $qr_payment_collection->payments_amount_received ?? 'NULL' }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label"><i class="fas fa-fingerprint me-1"></i>Payment ID</label>
                            <div class="field-value">{{ $qr_payment_collection['payment_id'] ?? 'NULL' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label"><i class="fas fa-hashtag me-1"></i>UTR Number</label>
                            <div class="field-value">{{ $qr_payment_collection->utr_number ?? 'NULL' }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label"><i class="fas fa-calendar-alt me-1"></i>Transaction Date</label>
                            <div class="field-value">
                                {{ $qr_payment_collection?->created_at?->format('d M Y, h:i A') ?? 'NULL' }}
                            </div>

                        </div><br><br>

                        <!-- New Fields Below -->
                        <h5>Customer Details</h5>
                        <div class="col-md-6">
                            <label class="field-label"><i class="fas fa-envelope me-1"></i>Email</label>
                            <div class="field-value">{{ $users->email ?? 'NULL' }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="field-label"><i class="fas fa-phone me-1"></i>Mobile No.</label>
                            <div class="field-value">{{ $users->mobile_no ?? 'NULL' }}</div>
                        </div>

                    </div>

                    <div class="divider mt-3"></div>
                </div>

                <div class="modal-footer receipt-footer justify-content-between no-print">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close" wire:click="closeSlipModal" >
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn  btn-light" onclick="printSlipOnly()">
                        <i class="fas fa-print me-2"></i>Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

    @endif
    @include('admin.razorpay.razorpay')
    <style>
        .receipt-container {
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.5);
        }

        .receipt-body {
            background-color: white;
            padding: 15px;
        }

        .receipt-footer {
            background-color: #f8f9fa;
            padding: 20px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            border-top: 1px solid #eee;
        }

        .field-label {
            font-weight: 600;
            /* border-bottom: 2px solid rgb(0, 27, 90); */
            color: #555;
            margin-bottom: 5px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .field-value {
            padding: 7px;
            background: rgba(215, 217, 220, 0.22);
            box-shadow: 0px 2px 2px rgba(0, 27, 90, 0.19);
            border-radius: 3px;
            color: #333;
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .field-value:hover {
            border-color: #4b6cb7;
            box-shadow: 0 0 0 3px rgba(75, 108, 183, 0.1);
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0));
            margin: 20px 0;
        }

        .btn-print {
            background: linear-gradient(135deg, #4b6cb7 0%, rgb(217, 221, 230) 100%);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(75, 108, 183, 0.2);
            transition: all 0.3s;
        }

        .btn-print:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(75, 108, 183, 0.25);
        }

        .btn-cancel {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #6c757d;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background-color: #e9ecef;
            color: #495057;
        }

        .logo-container {
            background-color: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        @media print {
            .receipt-container {
                box-shadow: none;
            }

            .no-print {
                display: none;
            }

            .receipt-header {
                background: #4b6cb7 !important;
                -webkit-print-color-adjust: exact;
            }

            .success-badge {
                background: #28a745 !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</div>

<script>
    function printSlipOnly() {
        const slipContent = document.getElementById("print-content").cloneNode(true); // Deep clone
        const printWindow = window.open('', '', 'height=800,width=900');

        // Optional: Remove Livewire directives and unnecessary attributes from slipContent
        slipContent.querySelectorAll('*').forEach(el => {
            el.removeAttribute('wire:ignore');
            el.removeAttribute('wire:ignore.self');
            el.removeAttribute('wire:key');
            el.removeAttribute('wire:id');
        });

        // Open the print window
        printWindow.document.open();
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Payment Receipt</title>
                <!-- Include Bootstrap for styling (optional if used in modal) -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <!-- Include FontAwesome if you use icons -->
                <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
                <style>
                    body {
                        font-family: 'Segoe UI', sans-serif;
                        padding: 40px;
                        background: #fff;
                        color: #000;
                    }
                    .receipt-body {
                        background: #f9f9f9;
                        padding: 20px;
                        border: 1px solid #ccc;
                        border-radius: 10px;
                    }
                    .field-label {
                        font-weight: 600;
                        margin-bottom: 4px;
                        color: #333;
                    }
                    .field-value {
                        padding: 10px 12px;
                        background: #f5f5f5;
                        border-radius: 6px;
                        border: 1px solid #ccc;
                        margin-bottom: 10px;
                    }
                    .divider {
                        height: 1px;
                        background: #ccc;
                        margin: 20px 0;
                    }
                    .logo-container {
                        margin-bottom: 10px;
                    }
                    .badge-success {
                        text-align: center;
                        margin-top: 30px;
                        font-size: 16px;
                        font-weight: 600;
                        padding: 10px 0;
                        background: #28a745;
                        color: white;
                        border-radius: 5px;
                    }

                    // @media print {
                    // .receipt-body {
                    // max-height: none !important;
                    // overflow: visible !important;
                    //  }
                    // }

                </style>
            </head>
            <body>
              
                <div class="receipt-body">
                    ${slipContent.innerHTML}
                </div>
                <div class="badge-success">Payment Successful</div>
            </body>
            </html>
        `);
        printWindow.document.close();

        setTimeout(() => {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }, 500);


        window.addEventListener('show-form', () => {
            const modal = new bootstrap.Modal(document.getElementById('form'));
            modal.show();
        });
    }
</script>