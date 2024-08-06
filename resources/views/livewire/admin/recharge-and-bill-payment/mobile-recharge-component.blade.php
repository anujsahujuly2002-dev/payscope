<div class="container mt-3">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class=" nav-link {{ $currentForm === 'form1' ? 'active' : '' }}" href="#"
                                wire:click.prevent="showForm('form1')">Mobile Recharge</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentForm === 'form2' ? 'active' : '' }}" href="#"
                                wire:click.prevent="showForm('form2')">Postpaid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentForm === 'form3' ? 'active' : '' }}" href="#"
                                wire:click.prevent="showForm('form3')">DTH</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentForm === 'form4' ? 'active' : '' }}" href="#"
                                wire:click.prevent="showForm('form4')">Electricity</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body" style="background-color: #E7ECF2;">
                    @if ($currentForm === 'form1')
                        <form>
                            <div>
                                <label for="operator" style="font-weight: bold">Operator</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="">Select</option>
                                    <option value="1">Airtel</option>
                                    <option value="2">Jio</option>
                                    <option value="3">Vodafone</option>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label for="state" style="font-weight: bold">State</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="">Select</option>
                                    <option value="1">Uttar Pradesh</option>
                                    <option value="2">Madhya Pradesh</option>
                                    <option value="3">Bihar</option>
                                    <option value="3">Gujrat</option>
                                    <option value="3">Goa</option>
                                    <option value="3">Assam</option>
                                </select>
                            </div>
                            <div class="form-group mt-1">
                                <label for="mobile" style="font-weight: bold">Mobile No.</label>
                                <input type="text" class="form-control" id="mobile"
                                    placeholder="Enter Your Mobile Number">
                            </div>
                            <div class="form-group mt-1">
                                <label for="amount" style="font-weight: bold">Amount</label>
                                <input type="text" class="form-control" id="amount"
                                    placeholder="Enter Your Amount">
                            </div>
                            <button type="submit" class="btn mt-2" style="background-color: rgb(53, 53, 199); color:white">Proceed</button>
                        </form>
                    @elseif ($currentForm === 'form2')
                    <form>
                        <div class="form-group mt-1">
                            <label for="state" style="font-weight: bold">State</label>
                            <select class="form-select" aria-label="Default select example">
                                <option value="">Select</option>
                                <option value="1">Uttar Pradesh</option>
                                <option value="2">Madhya Pradesh</option>
                                <option value="3">Bihar</option>
                                <option value="3">Gujrat</option>
                                <option value="3">Goa</option>
                                <option value="3">Assam</option>
                            </select>
                        </div>
                        <div>
                            <label for="operator" style="font-weight: bold">Operator</label>
                            <select class="form-select" aria-label="Default select example">
                                <option value="">Select</option>
                                <option value="1">Airtel</option>
                                <option value="2">Jio</option>
                                <option value="3">Vodafone</option>
                            </select>
                        </div>
                        <div class="form-group mt-1">
                            <label for="mobile" style="font-weight: bold">Mobile No.</label>
                            <input type="text" class="form-control" id="mobile"
                                placeholder="Enter Your Mobile Number">
                        </div>
                        <div class="form-group mt-1">
                            <label for="amount" style="font-weight: bold">Amount</label>
                            <input type="text" class="form-control" id="amount"
                                placeholder="Enter Your Amount">
                        </div>
                        <button type="submit" class="btn mt-2" style="background-color: rgb(24, 24, 167); color:white">Proceed</button>
                    </form>
                    @elseif ($currentForm === 'form3')
                    <form>
                        <div>
                            <label for="operator" style="font-weight: bold">Operator</label>
                            <select class="form-select" aria-label="Default select example">
                                <option value="">Select</option>
                                <option value="1">Airtel Digital TV</option>
                                <option value="2">Dish TV</option>
                                <option value="3">Sun Direct</option>
                                <option value="3">D2H</option>
                                <option value="3">Tata Play</option>
                            </select>
                        </div>
                        <div class="form-group mt-1">
                            <label for="state" style="font-weight: bold">State</label>
                            <select class="form-select" aria-label="Default select example">
                                <option value="">Select</option>
                                <option value="1">Uttar Pradesh</option>
                                <option value="2">Madhya Pradesh</option>
                                <option value="3">Bihar</option>
                                <option value="3">Gujrat</option>
                                <option value="3">Goa</option>
                                <option value="3">Assam</option>
                            </select>
                        </div>
                        <div class="form-group mt-1">
                            <label for="mobile" style="font-weight: bold">Mobile No./ Subscriber Id</label>
                            <input type="text" class="form-control" id="mobile"
                                placeholder="Enter Your Registered Mobile No./ Subscriber Id">
                        </div>
                        <div class="form-group mt-1">
                            <label for="amount" style="font-weight: bold">Amount</label>
                            <input type="text" class="form-control" id="amount"
                                placeholder="Enter Your Amount">
                        </div>
                        <button type="submit" class="btn mt-2" style="background-color: rgb(24, 24, 167); color:white">Proceed</button>
                    </form>
                    @elseif ($currentForm === 'form4')
                    <form>
                        <div class="form-group mt-1">
                            <label for="state" style="font-weight: bold">State</label>
                            <select class="form-select" aria-label="Default select example">
                                <option value="">Select</option>
                                <option value="1">Uttar Pradesh</option>
                                <option value="2">Madhya Pradesh</option>
                                <option value="3">Bihar</option>
                                <option value="3">Gujrat</option>
                                <option value="3">Goa</option>
                                <option value="3">Assam</option>
                            </select>
                        </div>
                        <div>
                            <label for="operator" style="font-weight: bold">Billers</label>
                            <select class="form-select" aria-label="Default select example">
                                <option value="">Select</option>
                                <option value="1">NPCL Noida</option>
                                <option value="2">Torrent Power</option>
                                <option value="3">BEST Mumbai</option>
                            </select>
                        </div>

                        <div class="form-group mt-1">
                            <label for="consumer" style="font-weight: bold">Consumer No.</label>
                            <input type="text" class="form-control" id="consumer"
                                placeholder="Enter Your consumer Number">
                        </div>
                        <div class="form-group mt-1">
                            <label for="amount" style="font-weight: bold">Amount</label>
                            <input type="text" class="form-control" id="amount"
                                placeholder="Enter Your Amount">
                        </div>
                        <button type="submit" class="btn mt-2" style="background-color: rgb(24, 24, 167); color:white">Proceed</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @if($showSecondCard)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class=" nav-link {{ $currentForm1 === 'form1' ? 'active' : '' }}" href="#"
                                wire:click.prevent="showForm1('form1')">Mobile Recharge</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentForm1 === 'form2' ? 'active' : '' }}" href="#"
                                wire:click.prevent="showForm1('form2')">Postpaid</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body" style="background-color: #E7ECF2;">
                    @if ($currentForm1 === 'form1')
                    <div class="faq-box wow fadeInUp">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Popular Plans
                                    </button>
                                </h5>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table style=" width: 100%; border-collapse: collapse;">
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Data
                                    </button>
                                </h5>
                                <div id="collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        International Roaming
                                    </button>
                                </h5>
                                <div id="collapseFive" class="accordion-collapse collapse"
                                    aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingsix">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapsesix" aria-expanded="false"
                                        aria-controls="collapsesix">
                                            Talktime (Top Up Voucher)
                                    </button>
                                </h5>
                                <div id="collapsesix" class="accordion-collapse collapse"
                                    aria-labelledby="headingsix" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingsaven">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapsesaven"
                                        aria-expanded="false" aria-controls="collapsesaven">
                                        Other Packs
                                    </button>
                                </h5>
                                <div id="collapsesaven" class="accordion-collapse collapse"
                                    aria-labelledby="headingsaven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif ($currentForm1 === 'form2')
                    <div class="faq-box wow fadeInUp">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        International Roaming
                                    </button>
                                </h5>
                                <div id="collapseFive" class="accordion-collapse collapse"
                                    aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Popular Plans
                                    </button>
                                </h5>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree">
                                        Truly Unlimited
                                    </button>
                                </h5>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Data
                                    </button>
                                </h5>
                                <div id="collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingsix">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapsesix" aria-expanded="false"
                                        aria-controls="collapsesix">
                                            Talktime (Top Up Voucher)
                                    </button>
                                </h5>
                                <div id="collapsesix" class="accordion-collapse collapse"
                                    aria-labelledby="headingsix" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="headingsaven">
                                    <button class="accordion-button collapsed" type="button" style="font-weight: bold"
                                        data-bs-toggle="collapse" data-bs-target="#collapsesaven"
                                        aria-expanded="false" aria-controls="collapsesaven">
                                        Other Packs
                                    </button>
                                </h5>
                                <div id="collapsesaven" class="accordion-collapse collapse"
                                    aria-labelledby="headingsaven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Amount</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Validity</th>
                                                <th style="border: 1px solid #ddd; padding: 8px; background-color: #f2f2f2;">Description</th>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹199</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">28 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">1.5GB/day, Unlimited Calls</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹399</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">56 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">2GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; padding: 8px;">₹599</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">84 Days</td>
                                                <td style="border: 1px solid #ddd; padding: 8px;">3GB/day, Unlimited Calls, 100 SMS/day</td>
                                            </tr>
                                        </table>
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
