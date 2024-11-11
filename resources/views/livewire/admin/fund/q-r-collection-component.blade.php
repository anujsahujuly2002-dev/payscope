<div>
    <div wire:loading class="loading"></div>
    @include('admin.flash-message.flash-message')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-contenet-between">
                        <div class="d-flex justify-contenet-between">
                            <div class="d-flex justify-contenet-between">
                                <div>
                                    <h4 style="font-weight: bold">Overview</h4>
                                </div>
                                <div>
                                    <h6 class="mb-1 mt-1 ms-4 text-muted"><i class="fa fa-clock me-2"></i>8 min Ago</h6>
                                </div>
                                <div class="ms-4">
                                    <a wire:click="" wire:loading.attr="disabled"
                                        class=" cursor-pointer border-0 flex items-center space-x-2 transition duration-200">
                                        <i class="fas fa-sync-alt" style="color: blue"></i>
                                        <span class="ms-2" style="color: blue">Refresh</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-contenet-between" style="margin-left: 500px">
                            <div class="d-flex justify-contenet-between">
                                <div>
                                    <a wire:click="settlement" wire:loading.attr="disabled" class="cursor-pointer border-0 flex items-center space-x-2 transition duration-200">
                                        <i class="fa fa-info-circle" style="color: blue"></i>
                                        <span class="ms-2" style="color: blue">My Settlement Cycle</span>
                                    </a>
                                </div>
                                <hr>
                                <div class="ms-5">
                                    <a href="https://groscope.com/" wire:loading.attr="disabled"
                                        class=" cursor-pointer border-0 flex items-center space-x-2 transition duration-200">
                                        <span class="ms-2" style="color: blue">Documentation</span>
                                        <i class="fas fa-book ms-2" style="color: blue"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex">
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <p class="mb-0 ">Current Balance <i class="fa fa-info-circle ms-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="This is the total amount that is due to be deposited in your bank account after deduction of taxes, platform fees, any other applicable charges, and adjustment of refunds and credits."></i>
                                    </p>
                                    <h3 class="mb-1 mt-1 "> &#x20B9; <span class="counterup">1234</span></h3>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <p class=" mb-0 ">Settelement due today <i class="fa fa-info-circle ms-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="This is the amount initiated for deposit into your bank account and is in processing."></i>
                                    </p>
                                    <h3 class="mb-1 mt-1 "> &#x20B9; <span class="counterup">1234</span></h3>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <p class=" mb-0 ">Previous Settelement <i class="fa fa-info-circle ms-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="This is the last amount initiated for deposit into your bank account (the settlement may have either processed or failed)."></i>
                                    </p>
                                    <h3 class="mb-1 mt-1 "> &#x20B9; <span class="counterup">1234</span></h3>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <p class="mb-0 ">Upcoming Settelement <i class="fa fa-info-circle ms-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="This is the amount that’ll be deposited into your bank account next as per your settlement cycle."></i>
                                    </p>
                                    <h3 class="mb-1 mt-1 "> &#x20B9; <span class="counterup">1234</span></h3>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col-->
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
                                            placeholder="QR Code Id" wire:model.live='value'>
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
                                                @can('qr-request-add-fund')
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-success d-flex align-items-center justify-content-center rounded-circle"
                                                        style="width: 40px; height: 40px; padding: 0; font-size: 20px; line-height: 1;"
                                                        wire:click.prevent='walletLoad'><i class="mdi mdi-plus"></i></a>
                                                @endcan
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
                                    <th scope="col">QR Current Status</th>
                                    <th scope="col">QR Close Reason</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($qr_collection as $key => $item)
                                    <tr>
                                        <th scope="row">
                                            <div class="form-check font-size-16">
                                                <label class="form-check-label"
                                                    for="contacusercheck1">{{ $loop->iteration }}</label>
                                            </div>
                                        </th>
                                        @if (auth()->user()->getRoleNames()->first() == 'super-admin')
                                            <td>
                                                <a href="javascript:void(0)"
                                                    class="text-body">{{ $item->user->name }}</a>
                                            </td>
                                        @endif

                                        <td>
                                            {{ $item->qr_code_id }}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{ moneyFormatIndia($item->payment_amount) }}
                                        </td>
                                        <td class="fw-bolder">
                                            &#x20B9;{{ moneyFormatIndia($item->payments_amount_received) }}
                                        </td>

                                        <td>
                                            Payment Id:-{{ $item->payment_id }} <br> UPI Id:-{{ $item->payer_name }}
                                            <br>
                                            UTR Number :-{{ $item->utr_number }}
                                        </td>
                                        <td>
                                            {{ ucfirst($item->qr_status) }}
                                        </td>
                                        <td>
                                            {{ ucfirst($item->close_reason) }}
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            {!! $item->status->name !!}
                                        </td>
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
                                                <a href="javascript:void()" class="page-link"><i
                                                        class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item" wire:click="previousPage">
                                                <a href="javascript:void()" class="page-link"><i
                                                        class="mdi mdi-chevron-left"></i></a>
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
                                                    <a href="javascript:void(0)"
                                                        class="page-link">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        @if ($qr_collection->currentPage() < $qr_collection->lastPage() - 3)
                                            <li class="page-item">
                                                <a href="javascript:void(0)" class="page-link">....</a>
                                            </li>
                                        @endif

                                        @if ($qr_collection->currentPage() < $qr_collection->lastPage() - 2)
                                            <li class="page-item"
                                                wire:click="gotoPage({{ $qr_collection->lastPage() }})">
                                                <a href="javascript:void(0)"
                                                    class="page-link">{{ $qr_collection->lastPage() }}</a>
                                            </li>
                                        @endif

                                        @if ($qr_collection->hasMorePages())
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

    @if ($settlementForm)
    <div class="modal fade" id="form" tabindex="-1" aria-labelledby="settlementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="settlementModalLabel">Settlement Cycle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Card with overflow effect -->
                        <div class="card card-overflow">
                            <div class="card-body">
                                <h6> <span style="font-size: 24px;" class="me-2">&#8226;</span> Payments default
                                    settlement cycle</h6>
                                <div class="mb-3">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="text-align: left; padding-left: 10px; padding-top: 2px; padding-bottom: 2px;">
                                                    Domestic Payments</td>
                                                <th
                                                    style="text-align: right; padding-right: 10px; padding-top: 2px; padding-bottom: 2px;">
                                                    T+1 10AM</th>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="text-align: left; padding-left: 10px; padding-top: 2px; padding-bottom: 2px;">
                                                    Internationl Payments</td>
                                                <th
                                                    style="text-align: right; padding-right: 10px; padding-top: 2px; padding-bottom: 2px;">
                                                    T+7 11AM</th>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div>
                                                        <p class="m-0 p-0">
                                                            <strong>Note: </strong> Some international payment methods
                                                            have
                                                            a different schedule.
                                                            <a data-bs-toggle="collapse" href="#collapseExample"
                                                                role="button" aria-expanded="false"
                                                                aria-controls="collapseExample"> View schedules
                                                            </a>
                                                        <div class="collapse" id="collapseExample">
                                                            <table class="table border"
                                                                style="width: 100%; border-collapse: collapse;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td
                                                                            style="text-align: left; padding-left: 10px; padding-top: 2px; padding-bottom: 2px;">
                                                                            Payment Method</td>
                                                                        <td
                                                                            style="text-align: right; padding-right: 10px; padding-top: 2px; padding-bottom: 2px;">
                                                                            Settlement schedule</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="color: rgb(11, 11, 11); text-align: left; padding-left: 10px; padding-top: 2px; padding-bottom: 2px;">
                                                                            Card</td>
                                                                        <td
                                                                            style="color: rgb(11, 11, 11); text-align: right; padding-right: 10px; padding-top: 2px; padding-bottom: 2px;">
                                                                            T+1 4AM</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div style="margin-top: -43px;">
                                        <p class="ms-4 text-muted  m-0 p-0"><span style="font-size: 24px; color:red"
                                                class="me-2">&#8226;</span>T is the date
                                            of payment capture</p>
                                    </div>
                                    <h6 class="mt-1"><span style="font-size: 24px;"
                                            class="me-2">&#8226;</span>Other
                                        Settlement cycle</h6>
                                    <table class="table m-0 p-0 ms-3">
                                        <tbody class="m-0" style="">
                                            <tr class="text-center">
                                                <td style="color:rgb(11, 11, 11); text-align:left;">Refunds</td>
                                                <th scope="col">Instant</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div style="background-color: rgb(255, 242, 186); margin-top:-35px">
                                <p class="ms-4 mt-2">
                                    <strong>Note:</strong> <span style="color: rgb(255, 196, 0)">Bank holidays</span>
                                    aren’t counted as working days.
                                    <a href="#">View Example</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Button Group -->
                    <div class="button-group mb-2">
                        <button class="btn1" wire:click="holiday" data-bs-toggle="modal" wire:loading.attr="disabled"
                            data-bs-target="#holidayModal">List of Bank Holidays</button>
                        <button class="btn">Settlement Guide</button>
                    </div>
                </div>
            </div>
        </div>
    @elseif($holidayForm)
        <div class="modal fade" id="holidayModal" tabindex="-1" aria-labelledby="holidayModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="settlementModalLabel">Holiday List</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-overflows">
                            <div class="card-body1">
                                <div class="mb-3">
                                    <table class="my-table border-1">
                                        <thead class="my-table-heading">
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>26/01/2024</td>
                                                <td>Republic Day</td>
                                            </tr>
                                            <tr>
                                                <td>19/02/2024</td>
                                                <td>Chhatrapati Shivaji Maharaj Jayanti</td>
                                            </tr>
                                            <tr>
                                                <td>08/03/2024</td>
                                                <td>Mahashivratri</td>
                                            </tr>
                                            <tr>
                                                <td>25/03/2024</td>
                                                <td>Holi (Second Day) Dhuleti/dol Jatra</td>
                                            </tr>
                                            <tr>
                                                <td>29/03/2024</td>
                                                <td>Good Friday</td>
                                            </tr>
                                            <tr>
                                                <td>01/04/2024</td>
                                                <td>Bank to close their yearly accounts</td>
                                            </tr>
                                            <tr>
                                                <td>09/04/2024</td>
                                                <td>Chaitra Sukladi/Gudi Padwa/Ugadi/Cheti Chand/1st Navratri</td>
                                            </tr>
                                            <tr>
                                                <td>11/04/2024</td>
                                                <td>Ramzan-id (id-ul-fitr)</td>
                                            </tr>
                                            <tr>
                                                <td>17/04/2024</td>
                                                <td>Shree Ram Navami (Chaite Dasain)</td>
                                            </tr>
                                            <tr>
                                                <td>01/05/2024</td>
                                                <td>Maharashtra Din/ may Day</td>
                                            </tr>
                                            <tr>
                                                <td>23/05/2024</td>
                                                <td>Buddha Purnima</td>
                                            </tr>
                                            <tr>
                                                <td>17/06/2024</td>
                                                <td>Bakri Eid (eid-ul-zuha)</td>
                                            </tr>
                                            <tr>
                                                <td>17/07/2024</td>
                                                <td>Muharram/ashoora</td>
                                            </tr>
                                            <tr>
                                                <td>15/08/2024</td>
                                                <td>Independence day</td>
                                            </tr>
                                            <tr>
                                                <td>07/09/2024</td>
                                                <td>Ganesh Chaturthi/samvatsari(Chaturthi Paksha)/varasiddhi Vinayaka Vrata/Vinayakar Chaturthi</td>
                                            </tr>
                                            <tr>
                                                <td>16/09/2024</td>
                                                <td>Milad-un-nabi Or Id-e-milad(birthday of Profet Mohammad)(Bara Vafat)</td>
                                            </tr>
                                            <tr>
                                                <td>02/10/2024</td>
                                                <td>Mahatma Gandhi Jayanti</td>
                                            </tr>
                                            <tr>
                                                <td>12/10/2024</td>
                                                <td>Dussehra/Vijaydashmi</td>
                                            </tr>
                                            <tr>
                                                <td>01/11/2024</td>
                                                <td>Diwali Amavasya(Laxmi Pujan)/Deepawali/Kannad Rajyothsava</td>
                                            </tr>
                                            <tr>
                                                <td>01/11/2024</td>
                                                <td>Diwali(Bali Pratipada)/balipadyami/laxmi(Deepawali)/Govardhan Pooja/Vikram Samvant New Year Day</td>
                                            </tr>
                                            <tr>
                                                <td>15/11/2024</td>
                                                <td>Guru Nanak Jayanti/Kartika Purnima</td>
                                            </tr>
                                            <tr>
                                                <td>25/12/2024</td>
                                                <td>Christmas</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('admin.razorpay.razorpay')
</div>
