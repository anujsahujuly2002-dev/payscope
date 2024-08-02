<div>
    <style>
        .card-container {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }

        .card {
            margin-right: 20px;
            cursor: pointer;
        }

        .form-container {
            position: absolute;
            top: 0;
            left: 100%;
            margin-left: 10px;
            width: 300px;
        }
    </style>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card" style="cursor: pointer;" wire:click="openModal">
                        <div class="card-body text-center">
                            <img src="{{ asset('/assets/images/mobile.png') }}" height="70px;" alt="">
                            <h4 class="mt-2">Mobile</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="cursor: pointer;" wire:click="openModal1">
                        <div class="card-body text-center">
                            <img src="{{ asset('/assets/images/dth.png') }}" height="70px;" alt="">
                            <h4 class="mt-2">DTH</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="cursor: pointer;" wire:click="openModal2">
                        <div class="card-body text-center">
                            <img src="{{ asset('/assets/images/electricity.png') }}" height="70px;" alt="">
                            <h4 class="mt-2">Electricity</h4>
                        </div>
                    </div>
                </div>
                @if ($showModal)
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs">
                                    <li class="nav-item">
                                        <a class=" nav-link {{ $currentForm === 'form1' ? 'active' : '' }}"
                                            href="#" wire:click.prevent="showForm('form1')">Prepaid</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $currentForm === 'form2' ? 'active' : '' }}"
                                            href="#" wire:click.prevent="showForm('form2')">Postpaid</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body" style="background-color: rgb(234, 225, 225);">
                                @if ($currentForm === 'form1')
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/airtel.png') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/jio.png') }}" height="70px;"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/bsnl.png') }}" height="70px;"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/vodafone.png') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/idea.png') }}" height="70px;"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/telenor.jpg') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/aircel.png') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @elseif ($currentForm === 'form2')
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/aircel.png') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/airtel.png') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/bsnl.png') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/vodafone.png') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/idea.png') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/telenor.jpg') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/jio.png') }}"
                                                            height="70px;" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                @endif
            </div>
        </div>
    </div>
    @endif
    @if ($showModal1)
        <div class="col-md-9">
            <div class="card">
                {{-- <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs">
                                    <li class="nav-item">
                                        <a class=" nav-link {{ $currentForm === 'form1' ? 'active' : '' }}"
                                            href="#" wire:click.prevent="showForm('form1')">Prepaid</a>
                                    </li>
                                </ul>
                            </div> --}}
                <div class="card-body" style="background-color: rgb(234, 225, 225);">
                    @if ($currentForm === 'form1')
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card" style="cursor: pointer;" wire:click="">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('/assets/images/airtelTv.png') }}" height="100px;"
                                                alt="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card" style="cursor: pointer;" wire:click="">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('/assets/images/tataSky.png') }}" height="100px;"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card" style="cursor: pointer;" wire:click="">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('/assets/images/d2h.png') }}" height="100px;"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card" style="cursor: pointer;" wire:click="">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('/assets/images/dishtv.png') }}" height="100px;"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    @if ($showModal2)
        <div class="col-md-9">
            <div class="card">
                {{-- <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs">
                                    <li class="nav-item">
                                        <a class=" nav-link {{ $currentForm === 'form1' ? 'active' : '' }}"
                                            href="#" wire:click.prevent="showForm('form1')">Prepaid</a>
                                    </li>
                                </ul>
                            </div> --}}
                <div class="card-body" style="background-color: rgb(234, 225, 225);">
                    @if ($currentForm === 'form1')
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card" style="cursor: pointer;" wire:click="">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('/assets/images/tp.png') }}" height="130px;"
                                                alt="">
                                            {{-- <h4 class="mt-2">Electricity</h4> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card" style="cursor: pointer;" wire:click="">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('/assets/images/kesko.png') }}" height="130px;"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card" style="cursor: pointer;" wire:click="">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('/assets/images/npcl.jpg') }}" height="130px;"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card" style="cursor: pointer;" wire:click="">
                                        <div class="card-body text-center">
                                            <img src="{{ asset('/assets/images/tpower.png') }}" height="130px;"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

</div>
