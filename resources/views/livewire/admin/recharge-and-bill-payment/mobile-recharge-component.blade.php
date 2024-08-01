<div>
    <style>
        .card-container {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
        }

        .card {
            margin-right: 20px;
            /* Adjust as needed */
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
        <!-- Card -->
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
                            {{-- <p class="card-text">Click to open recharge form.</p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="cursor: pointer;" wire:click="openModalEle">
                        <div class="card-body text-center">
                            <img src="{{ asset('/assets/images/electricity.png') }}" height="70px;" alt="">
                            <h4 class="mt-2">Electricity</h4>
                            {{-- <p class="card-text">Click to open recharge form.</p> --}}
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
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
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
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
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
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH f</h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
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
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
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
                @if ($showModalEle)
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
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">Electricity</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}" height="70px;"
                                                            alt="">
                                                        <h4 class="mt-2">DTH</h4>
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
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card" style="cursor: pointer;" wire:click="">
                                                    <div class="card-body text-center">
                                                        <img src="{{ asset('/assets/images/dth.png') }}"
                                                            height="70px;" alt="">
                                                        <h4 class="mt-2">DTH</h4>
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
            </div>

        </div>
