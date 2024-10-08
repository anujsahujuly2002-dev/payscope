<div>
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card" style="background-color:#0a1d56;">
                <div class="card-body">
                    <div class="float-end mt-2">
                        {{-- <div id="growth-chart" data-colors='["--bs-success"]'></div> --}}
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1 text-white"> &#x20B9; <span
                                class="counterup">{{ $paymentIn['amount']??0 }}</span></h4>
                        <p class="text-white mb-0 ">Total Payment In</p>
                    </div>
                    <p class="text-white mt-3 mb-0"><span class="text-success me-1"><i
                                class="mdi mdi-arrow-up-bold me-1"></i>0%</span> since last week
                    </p>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="card" style="background-color:#fc0800;">
                <div class="card-body">
                    <div class="float-end mt-2">
                        {{-- <div id="growth-chart1" data-colors='["--bs-success"]'></div> --}}
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1 text-white"> &#x20B9; <span
                                class="counterup">{{ $rejectedPayment['amount']??0 }}</span></h4>
                        <p class="text-white mb-0">Total Rejected Payout</p>
                    </div>

                    <p class="text-white mt-3 mb-0"><span class="text-success me-1"><i
                                class="mdi mdi-arrow-up-bold me-1"></i>0%</span> since last week
                    </p>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="card" style="background-color:#0a1d56;">
                <div class="card-body">
                    <div class="float-end mt-2">
                        {{-- <div id="growth-chart2" data-colors='["--bs-success"]'> </div> --}}
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1 text-white"> &#x20B9; <span class="counterup">{{ $payout['amount']??0 }}</span></h4>
                        <p class="text-white mb-0">Total Payout</p>
                    </div>
                    <p class="text-white mt-3 mb-0"><span class="me-1 text-warning"><i
                                class="mdi mdi-arrow-down-bold me-1"></i>0%</span> since last week
                    </p>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-3">
            <div class="card" style="background-color:#ff0800">
                <div class="card-body">
                    <div class="float-end mt-2">
                        {{-- <div id="growth-chart3" data-colors='["--bs-success"]'> </div> --}}
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1 text-white">&#x20B9;<span
                                class="counterup">{{ $commission['amount']??0 }}</span></h4>
                        <p class="text-white mb-0">Total Payout Charges:</p>
                    </div>
                    <p class="text-white mt-3 mb-0"><span class="me-1 text-warning"><i
                                class="mdi mdi-arrow-down-bold me-1"></i>0%</span> since last week
                    </p>
                </div>
            </div>
        </div> <!-- end col-->
    </div> <!-- end row-->

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="float-end">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton5"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fw-semibold" style="">Sort By:</span> <span
                                    style="">Yearly<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton5"
                                style="">
                                <a class="dropdown-item" href="#">Monthly</a>
                                <a class="dropdown-item" href="#">Yearly</a>
                                <a class="dropdown-item" href="#">Weekly</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4" style="">Sales Analytics</h4>
                    <div class="mt-1">
                        <ul class="list-inline main-chart mb-0">
                            <li class="list-inline-item chart-border-left me-0 border-0">
                                <h3 style="">&#x20B9;<span class="counterup">{{ $payout ['amount']??0}}</span><span
                                        class="d-inline-block font-size-15 ms-3" style="">Income</span>
                                </h3>
                            </li>
                            <li class="list-inline-item chart-border-left me-0">
                                <h3><span data-plugin="counterup" style="">0</span><span
                                        class="d-inline-block font-size-15 ms-3" style="">Sales</span>
                                </h3>
                            </li>
                            <li class="list-inline-item chart-border-left me-0">
                                <h3><span data-plugin="counterup" style="">0</span>%<span
                                        class="d-inline-block font-size-15 ms-3" style="">Conversation
                                        Ratio</span></h3>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-3">
                        <div id="sales-analytics-chart" data-colors='["#0a1d56", "#dfe2e6", "#ff0800"]'
                            class="apex-charts" dir="ltr"></div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-4">
            <div class="card" style="background-color: #0a1d56">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <p class="text-white font-size-18">Enhance your <b>Campaign</b> for better outreach <i
                                    class="mdi mdi-arrow-right"></i></p>
                            <div class="mt-4">
                                <a href="javascript: void(0);"
                                    class="btn btn-success waves-effect waves-light">Upgrade Account!</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mt-4 mt-sm-0">
                                <img src="{{ asset('/assets/images/setup-analytics-amico.svg') }}" class="img-fluid"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->

            <div class="card">
                <div class="card-body">
                    <div class="float-end">
                        <div class="dropdown">
                            <a class="dropdown-toggle text-reset" href="#" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fw-semibold">Sort By:</span> <span style=";">Yearly<i
                                        class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                                <a class="dropdown-item" style="" href="#">Monthly</a>
                                <a class="dropdown-item" style="" href="#">Yearly</a>
                                <a class="dropdown-item" style="" href="#">Weekly</a>
                            </div>
                        </div>
                    </div>

                    <h4 class="card-title mb-4">Top Selling Products</h4>
                    <div class="row align-items-center g-0 mt-3">
                        <div class="col-sm-3">
                            <p style="" class="text-truncate mt-1 mb-0"><i
                                    class="mdi mdi-circle-medium text-primary me-2"></i>Total payout </p>
                        </div>

                        <div class="col-sm-9">
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar progress-bar bg-primary" role="progressbar"
                                    style="width: 52%" aria-valuenow="52" aria-valuemin="0" aria-valuemax="52">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row align-items-center g-0 mt-3">
                        <div class="col-sm-3">
                            <p style="" class="text-truncate mt-1 mb-0"><i
                                    class="mdi mdi-circle-medium text-info me-2"></i> iPhones </p>
                        </div>
                        <div class="col-sm-9">
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar progress-bar bg-info" role="progressbar" style="width: 45%"
                                    aria-valuenow="45" aria-valuemin="0" aria-valuemax="45">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row align-items-center g-0 mt-3">
                        <div class="col-sm-3">
                            <p style="" class="text-truncate mt-1 mb-0"><i
                                    class="mdi mdi-circle-medium text-success me-2"></i> Android </p>
                        </div>
                        <div class="col-sm-9">
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar progress-bar bg-success" role="progressbar"
                                    style="width: 48%" aria-valuenow="48" aria-valuemin="0" aria-valuemax="48">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row align-items-center g-0 mt-3">
                        <div class="col-sm-3">
                            <p style="" class="text-truncate mt-1 mb-0"><i
                                    class="mdi mdi-circle-medium text-warning me-2"></i> Tablets </p>
                        </div>
                        <div class="col-sm-9">
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar progress-bar bg-warning" role="progressbar"
                                    style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                    <div class="row align-items-center g-0 mt-3">
                        <div class="col-sm-3">
                            <p style="" class="text-truncate mt-1 mb-0"><i
                                    class="mdi mdi-circle-medium text-purple me-2"></i> Cables </p>
                        </div>
                        <div class="col-sm-9">
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar progress-bar bg-purple" role="progressbar"
                                    style="width: 63%" aria-valuenow="63" aria-valuemin="0" aria-valuemax="63">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row-->

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end Col -->
    </div> <!-- end row-->

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="float-end">
                        <div class="dropdown">
                            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span style="">All Members<i
                                        class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                <a class="dropdown-item" style="" href="#">Locations</a>
                                <a class="dropdown-item" style="" href="#">Revenue</a>
                                <a class="dropdown-item" style="" href="#">Join Date</a>
                            </div>
                        </div>
                    </div>
                    <h4 class="card-title mb-4" style="">Top Users</h4>

                    <div data-simplebar style="max-height: 339px;">
                        <div class="table-responsive">
                            <table class="table table-borderless table-centered table-nowrap">
                                <tbody>
                                    @foreach ($recentTransactions as $transactions)
                                        <tr>
                                            <td style="width: 20px;">
                                                <img src="{{ URL::asset('/assets/images/users/vector-team.png') }}"
                                                    class="avatar-xs rounded-circle " alt="...">
                                            </td>
                                            <td>
                                                <h6 class="font-size-15 mb-1 fw-normal">
                                                    {{ $transactions->user->name }}
                                                </h6>
                                                <p class="text-muted font-size-13 mb-0"><i
                                                        class="mdi mdi-map-marker"></i> Location</p>
                                            </td>
                                            <td><span
                                                    class="{{ $transactions->status_class }}">{{ strip_tags($transactions->status->name) }}</span>
                                            </td>
                                            <td class="text-muted fw-semibold text-end">
                                                <i class="icon-xs icon me-2 "></i>
                                                &#x20B9;{{ moneyFormatIndia($transactions->amount) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->
                    </div> <!-- data-sidebar-->
                </div><!-- end card-body-->
            </div> <!-- end card-->
        </div><!-- end col -->

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="float-end">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" id="dropdownMenuButton3"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span style="">Recent<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton3">
                                <a class="dropdown-item" href="#" style="">Recent</a>
                                <a class="dropdown-item" href="#" style="">By Users</a>
                            </div>
                        </div>
                    </div>

                    <h4 class="card-title mb-4" style="">Recent Activity</h4>

                    <ol class="activity-feed mb-0 ps-2" data-simplebar style="max-height: 339px;">
                        {{-- <li class="feed-item">
                            <div class="feed-item-list">
                                <p class="text-muted mb-1 font-size-13">Today<small class="d-inline-block ms-1">12:20 pm</small></p>
                                <p class="mb-0">Andrei Coman magna sed porta finibus, risus
                                    posted a new article: <span class="text-primary">Forget UX
                                        Rowland</span></p>
                            </div>
                        </li> --}}
                        @foreach ($loginActivities as $loginActivity)
                            <li class="feed-item">
                                <p class="mb-0"><span class="text-primary">{{ $loginActivity->user?->name }}</span>
                                </p>
                                <p class="mb-0">Login Time: {{ $loginActivity->login_time }}</p>
                                <p class="mb-0">Logout time: {{ $loginActivity->logout_time }}</p>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="float-end">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" id="dropdownMenuButton4"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span style="">Monthly<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton4">
                                <a class="dropdown-item" href="#" style="">Yearly</a>
                                <a class="dropdown-item" href="#" style="">Monthly</a>
                                <a class="dropdown-item" href="#" style="">Weekly</a>
                            </div>
                        </div>
                    </div>

                    <h4 class="card-title" style="">Social Source</h4>

                    <div class="text-center">
                        <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-soft-primary font-size-24">
                                <i class="mdi mdi-facebook text-primary"></i>
                            </span>
                        </div>
                        <p class="font-16 text-muted mb-2"></p>
                        <h5><a href="#" class="text-dark">Facebook - <span class="font-16"
                                    style=";">125 sales</span> </a></h5>
                        <p class="text-muted">Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero
                            venenatis faucibus tincidunt.</p>
                        <a href="#" class="text-reset font-16">Learn more <i
                                class="mdi mdi-chevron-right"></i></a>
                    </div>
                    <div class="row mt-4">
                        <div class="col-4">
                            <div class="social-source text-center mt-3">
                                <div class="avatar-xs mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-primary font-size-16">
                                        <i class="mdi mdi-facebook text-white"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-15">Facebook</h5>
                                <p class="text-muted mb-0">125 sales</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="social-source text-center mt-3">
                                <div class="avatar-xs mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-info font-size-16">
                                        <i class="mdi mdi-twitter text-white"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-15">Twitter</h5>
                                <p class="text-muted mb-0">112 sales</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="social-source text-center mt-3">
                                <div class="avatar-xs mx-auto mb-3">
                                    <span class="avatar-title rounded-circle bg-pink font-size-16">
                                        <i class="mdi mdi-instagram text-white"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-15">Instagram</h5>
                                <p class="text-muted mb-0">104 sales</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <a href="#" class="font-size-14 fw-medium">View All Sources <i
                                class="mdi mdi-chevron-right"></i></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4" style="">Latest Transaction</h4>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr style="">
                                    <th style="width: 20px;">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="customCheck1">
                                            <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Id</th>
                                    <th>Billing Name</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment Status</th>
                                    <th>Payment Type</th>
                                    <th>View Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentTransactions as $transactions)
                                    <tr>
                                        <td>
                                            <div class="form-check font-size-16">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>{{ $transactions->id }}</td>
                                        <td>{{ $transactions->user->name }}</td>
                                        <td>
                                            {{ $transactions->created_at }}
                                        </td>
                                        <td>
                                            &#x20B9;{{ moneyFormatIndia($transactions->amount) }}
                                        </td>
                                        <td>
                                            <span class="">{{ strip_tags($transactions->status->name) }}</span>
                                        </td>
                                        <td>
                                            <i class="fab fa-cc-mastercard me-1"></i> {{ $transactions->type }}
                                        </td>
                                        <td>
                                            <div class="mb-3 d-flex justify-content-center">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-success waves-effect waves-light align-self-end"
                                                    wire:click.prevent="transaction({{ $transactions->id }})"><i>Slip</a>

                                            </div>
                                        </td>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div>
        <div wire:ignore.self class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-small">
                @if ($selectedTransaction)
                    <div class="modal-content">
                        <div id="transaction-details" style="padding: 20px;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myLargeModalLabel">Personal Information</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <p class="mb-0">Transaction ID: <strong>{{ $selectedTransaction->fund_request?->payout_ref }}</strong></p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="mb-0">Payment Amount: <strong>{{ moneyFormatIndia($selectedTransaction->amount) }}</strong></p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="mb-0">Transaction Type: <strong>{{ $selectedTransaction->type }}</strong></p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="mb-0">UTR: <strong>{{ $selectedTransaction->utr_number }}</strong></p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="mb-0">Mode: <strong>{{ $selectedTransaction->payment_mode_id }}</strong></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <p class="mb-0">Status: <strong>{{ strip_tags($selectedTransaction->status->name) }}</strong></p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="mb-0">Date/Time: <strong>{{ $selectedTransaction->created_at }}</strong></p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="mb-0">Description: <strong>{{ $selectedTransaction->remarks }}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-header">
                                <h5 class="modal-title" id="myLargeModalLabel">Beneficiary Detail</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <p class="mb-0">Name as per Bank: <strong>{{ $selectedTransaction->name }}</strong></p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="mb-0">Beneficiary Name: <strong>{{ $selectedTransaction->user->name }}</strong></p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="mb-0">IFSC: <strong>{{ strtoupper($selectedTransaction->bank?->ifsc_code) }}</strong></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <p class="mb-0">Account Number: <strong>{{ $selectedTransaction->account_number }}</strong></p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="mb-0">Beneficiary Type: <strong>{{ $selectedTransaction->transtype }}</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer p-0 m-0 mt-0">
                                    <button type="button" class="btn btn-secondary" onclick="downloadPdf()">Download</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p>No transaction selected.</p>
                @endif
            </div>
        </div>
    </div>
