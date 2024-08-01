<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class=" nav-link {{ $currentForm === 'form1' ? 'active' : '' }}" href="#"
                                wire:click.prevent="showForm('form1')">Cash Withdraw</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentForm === 'form2' ? 'active' : '' }}" href="#"
                                wire:click.prevent="showForm('form2')">Mini Statement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentForm === 'form3' ? 'active' : '' }}" href="#"
                                wire:click.prevent="showForm('form3')">Balance Enquiry</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $currentForm === 'form4' ? 'active' : '' }}" href="#"
                                wire:click.prevent="showForm('form4')">Adhaar Pay</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body" style="background-color: rgb(234, 225, 225);">
                    @if ($currentForm === 'form1')
                        <div>
                            <form>
                                <div>
                                    <label for="bank">Bank</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="">Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>

                                <div class="form-group mt-1">
                                    <label for="mob">Mobile No.</label>
                                    <input type="text" class="form-control" id="mob"
                                        placeholder="Enter Your Mobile No.">
                                </div>
                                <div class="form-group mt-1">
                                    <label for="amount">Cash Amount</label>
                                    <input type="text" class="form-control" id="amount"
                                        placeholder="Enter Your Cash Amount">
                                </div>

                                <div class="form-group mt-1">
                                    <label for="adhaar">Adhaar No.</label>
                                    <input type="text" class="form-control" id="adhaar"
                                        placeholder="Enter Your Adhaar No.">
                                </div>
                                <div>
                                    <label for="biometric">Biometric Type</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select</option>
                                        <option value="1">Morpho</option>
                                        <option value="2">Mantra</option>
                                        <option value="3">Aratek</option>
                                        <option value="3">Evolute</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Proceed</button>
                            </form>
                        </div>
                    @elseif ($currentForm === 'form2')
                        <div>
                            <form>
                                <div>
                                    <label for="bank">Bank</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>

                                <div class="form-group mt-1">
                                    <label for="mob">Mobile No.</label>
                                    <input type="text" class="form-control" id="mob"
                                        placeholder="Enter Your Mobile No.">
                                </div>
                                <div class="form-group mt-1">
                                    <label for="adhaar">Adhaar No.</label>
                                    <input type="text" class="form-control" id="adhaar"
                                        placeholder="Enter Your Adhaar No.">
                                </div>
                                <div class="form-group mt-1">
                                    <label for="biometric">Biometric Type</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select</option>
                                        <option value="1">Morpho</option>
                                        <option value="2">Mantra</option>
                                        <option value="3">Aratek</option>
                                        <option value="3">Evolute</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Proceed</button>
                            </form>
                        </div>
                    @elseif ($currentForm === 'form3')
                        <div>
                            <form>
                                <div>
                                    <label for="bank">Bank</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>

                                <div class="form-group mt-1">
                                    <label for="mobile">Mobile No.</label>
                                    <input type="text" class="form-control" id="mobile"
                                        placeholder="Enter Your Mobile No.">
                                </div>


                                <div class="form-group mt-1">
                                    <label for="input1">Biometric Type</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select</option>
                                        <option value="1">Morpho</option>
                                        <option value="2">Mantra</option>
                                        <option value="3">Aratek</option>
                                        <option value="3">Evolute</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Proceed</button>
                            </form>
                        </div>

                    @elseif ($currentForm === 'form4')
                        <div>
                            <form>
                                <div>
                                    <label for="bank">Bank</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option value="">Select</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>

                                <div class="form-group mt-1">
                                    <label for="mob">Mobile No.</label>
                                    <input type="text" class="form-control" id="mob"
                                        placeholder="Enter Your Mobile No.">
                                </div>
                                <div class="form-group mt-1">
                                    <label for="amount">Cash Amount</label>
                                    <input type="text" class="form-control" id="amount"
                                        placeholder="Enter Your Cash Amount">
                                </div>

                                <div class="form-group mt-1">
                                    <label for="adhaar">Adhaar No.</label>
                                    <input type="text" class="form-control" id="adhaar"
                                        placeholder="Enter Your Adhaar No.">
                                </div>
                                <div>
                                    <label for="biometric">Biometric Type</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select</option>
                                        <option value="1">Morpho</option>
                                        <option value="2">Mantra</option>
                                        <option value="3">Aratek</option>
                                        <option value="3">Evolute</option>
                                    </select>
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
