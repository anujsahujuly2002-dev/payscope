<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
<div class="container mt-5">
    <!-- First Card -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ $currentFormCard2 === 'form1' ? 'active' : '' }}" href="#" wire:click.prevent="showFormCard2('form1')">Mobile Recharge</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentFormCard2 === 'form2' ? 'active' : '' }}" href="#" wire:click.prevent="showFormCard2('form2')">Postpaid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentFormCard2 === 'form3' ? 'active' : '' }}" href="#" wire:click.prevent="showFormCard2('form3')">Dth</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentFormCard2 === 'form4' ? 'active' : '' }}" href="#" wire:click.prevent="showFormCard2('form3')">Electricity</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    @if ($currentFormCard2 === 'form1')
                        <div>
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
                                    <label for="circle" style="font-weight: bold">Circle</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="">Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
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
                                <button type="submit" class="btn btn-primary mt-2">Proceed</button>
                            </form>
                        </div>
                    @elseif ($currentFormCard2 === 'form2')
                        <div>
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
                                    <label for="circle" style="font-weight: bold">Circle</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="">Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
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
                                <button type="submit" class="btn btn-primary mt-2">Proceed</button>
                            </form>
                        </div>
                    @elseif ($currentFormCard2 === 'form3')
                        <div>
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
                                    <label for="circle" style="font-weight: bold">Circle</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="">Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
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
                                <button type="submit" class="btn btn-primary mt-2">Proceed</button>
                            </form>
                        </div>
                    @elseif ($currentFormCard2 === 'form4')
                        <div>
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
                                    <label for="circle" style="font-weight: bold">Circle</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="">Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
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
                                <button type="submit" class="btn btn-primary mt-2">Proceed</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link {{ $currentFormCard1 === 'form1' ? 'active' : '' }}" href="#" wire:click.prevent="showFormCard1('form1')">Mobile Recharge</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentFormCard1 === 'form2' ? 'active' : '' }}" href="#" wire:click.prevent="showFormCard1('form2')">Postpaid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentFormCard1 === 'form3' ? 'active' : '' }}" href="#" wire:click.prevent="showFormCard1('form3')">Dth</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentFormCard1 === 'form4' ? 'active' : '' }}" href="#" wire:click.prevent="showFormCard1('form3')">Electricity</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    @if ($currentFormCard1 === 'form1')
                        <div>
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
                                                <table>
                                                    <tr>
                                                        <th>Amount</th>
                                                        <th>Validity</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    <tr>
                                                        <td>₹199</td>
                                                        <td>28 Days</td>
                                                        <td>1.5GB/day, Unlimited Calls</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹399</td>
                                                        <td>56 Days</td>
                                                        <td>2GB/day, Unlimited Calls, 100 SMS/day</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹599</td>
                                                        <td>84 Days</td>
                                                        <td>3GB/day, Unlimited Calls, 100 SMS/day</td>
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
                                                        <th>Amount</th>
                                                        <th>Validity</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    <tr>
                                                        <td>₹199</td>
                                                        <td>28 Days</td>
                                                        <td>1.5GB/day, Unlimited Calls</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹399</td>
                                                        <td>56 Days</td>
                                                        <td>2GB/day, Unlimited Calls, 100 SMS/day</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹599</td>
                                                        <td>84 Days</td>
                                                        <td>3GB/day, Unlimited Calls, 100 SMS/day</td>
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
                                                        <th>Amount</th>
                                                        <th>Validity</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    <tr>
                                                        <td>₹199</td>
                                                        <td>28 Days</td>
                                                        <td>1.5GB/day, Unlimited Calls</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹399</td>
                                                        <td>56 Days</td>
                                                        <td>2GB/day, Unlimited Calls, 100 SMS/day</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹599</td>
                                                        <td>84 Days</td>
                                                        <td>3GB/day, Unlimited Calls, 100 SMS/day</td>
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
                                                        <th>Amount</th>
                                                        <th>Validity</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    <tr>
                                                        <td>₹199</td>
                                                        <td>28 Days</td>
                                                        <td>1.5GB/day, Unlimited Calls</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹399</td>
                                                        <td>56 Days</td>
                                                        <td>2GB/day, Unlimited Calls, 100 SMS/day</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹599</td>
                                                        <td>84 Days</td>
                                                        <td>3GB/day, Unlimited Calls, 100 SMS/day</td>
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
                                                        <th>Amount</th>
                                                        <th>Validity</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    <tr>
                                                        <td>₹199</td>
                                                        <td>28 Days</td>
                                                        <td>1.5GB/day, Unlimited Calls</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹399</td>
                                                        <td>56 Days</td>
                                                        <td>2GB/day, Unlimited Calls, 100 SMS/day</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹599</td>
                                                        <td>84 Days</td>
                                                        <td>3GB/day, Unlimited Calls, 100 SMS/day</td>
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
                                                        <th>Amount</th>
                                                        <th>Validity</th>
                                                        <th>Description</th>
                                                    </tr>
                                                    <tr>
                                                        <td>₹199</td>
                                                        <td>28 Days</td>
                                                        <td>1.5GB/day, Unlimited Calls</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹399</td>
                                                        <td>56 Days</td>
                                                        <td>2GB/day, Unlimited Calls, 100 SMS/day</td>
                                                    </tr>
                                                    <tr>
                                                        <td>₹599</td>
                                                        <td>84 Days</td>
                                                        <td>3GB/day, Unlimited Calls, 100 SMS/day</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($currentFormCard1 === 'form2')
                        <div>
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
                                    <label for="circle" style="font-weight: bold">Circle</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="">Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
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
                                <button type="submit" class="btn btn-primary mt-2">Proceed</button>
                            </form>
                        </div>
                    @elseif ($currentFormCard1 === 'form3')
                        <div>
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
                                    <label for="circle" style="font-weight: bold">Circle</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="">Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
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
                                <button type="submit" class="btn btn-primary mt-2">Proceed</button>
                            </form>
                        </div>
                    @elseif ($currentFormCard1 === 'form4')
                        <div>
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
                                    <label for="circle" style="font-weight: bold">Circle</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="">Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
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
                                <button type="submit" class="btn btn-primary mt-2">Proceed</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
