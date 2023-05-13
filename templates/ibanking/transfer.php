<form class="m-0" action="/banco/dashboard/sendmoney" enctype="multipart/form-data" method="POST">
    <?= $Self->tokenize() ?>
    <div class="wrapper">

        <div class="header">
            <div class="row no-gutters">
                <div class="col-auto">
                    <a href="/" onclick="javascript:history.go(-1)" class="btn  btn-link text-dark"><i class="material-icons">navigate_before</i></a>
                </div>
                <div class="col text-center"><img src="https://www.citizensbcanada.com/assets/images/logo.png" class="header-logo"></div>
                <div class="col-auto">
                    <a href="/profile" class="btn  btn-link text-dark"><i class="material-icons">account_circle</i></a>
                </div>
            </div>
        </div>

        <div class="container">

            <?= $Self->Toast() ?>

            <?php if ($UserInfo->pin === "0000") : ?>

                <h6 class="subtitle">Create Secure PIN</h6>
                <div class="row">
                    <input type="hidden" name="newpin" id="newpin" value="1">
                    <div class="col-12 col-md-12">
                        <div class="form-group float-label">
                            <input type="number" name="pin" maxlength="4" max="9999" class="form-control form-control-lg" required="">
                            <label class="form-control-label">Create New Pin</label>
                        </div>
                    </div>
                    <button class="btn btn-lg btn-default text-white btn-block btn-rounded shadow mt-3"><span>Create Pin</span></button>
                    <br>

                </div>
            <?php else : ?>

                <?php if ($Self->data['paystep'] == 1) : ?>
                    <h6 class="subtitle">Beneficiary Information</h6>
                    <div class="row">

                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="text" name="name" class="form-control" required="">
                                <label class="form-control-label">Name of Beneficiary</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="text" name="bankname" class="form-control" required="">
                                <label class="form-control-label">Beneficiary Bank Name</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="text" name="bankaddress" class="form-control" required="">
                                <label class="form-control-label">Beneficiary Bank Address</label>
                            </div>
                        </div>

                    </div>

                    <h6 class="subtitle">Transfer Accounts & Codes</h6>
                    <div class="row">

                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="text" name="swiftcode" class="form-control">
                                <label class="form-control-label">Swift Code</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="text" name="iban" class="form-control">
                                <label class="form-control-label">IBAN Number</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="text" name="abaroutine" class="form-control">
                                <label class="form-control-label">ABA/ROUTING Number</label>
                            </div>
                        </div>


                    </div>
                    <h6 class="subtitle">Account Number & Name</h6>
                    <div class="row">

                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="text" name="accno" class="form-control" required="">
                                <label class="form-control-label">Account Number</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="text" name="accname" class="form-control" required="">
                                <label class="form-control-label">Account Name</label>
                            </div>
                        </div>

                    </div>
                    <button class="btn btn-lg btn-default text-white btn-block btn-rounded shadow mt-3"><span>Continue Transfer</span></button>
                    <br>
                <?php elseif ($Self->data['paystep'] == 2) : ?>

                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                        <div class="modal-content my-0">
                            <div class="modal-body text-center pt-0">
                                <h6 class="subtitle">Transfer Security PIN <br /><small>enter four (4) digits pin</small></h6>
                                <button class="btn btn-default btn-rounded-54 shadow"><i class="material-icons">check_circle</i></button>
                                <div class="form-group mt-4">
                                    <input type="text" class="form-control form-control-lg text-center" maxlength="4" name="securepin" placeholder="* * * *" required="" autofocus="">
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Veirfy PIN</button>
                            </div>
                        </div>
                    </div>

                <?php elseif ($Self->data['paystep'] == 3) : ?>

                    <input type="hidden" name="setotp" id="setotp" value="1">
                    <div class="modal-dialog modal-sm modal-dialog-centered mt-0" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center pt-0">
                                <h6 class="subtitle">Check OTP <br /><small>check your email and phone</small></h6>
                                <button class="btn btn-default btn-rounded-54 shadow"><i class="material-icons">check_circle</i></button>
                                <div class="form-group mt-4">
                                    <input type="text" class="form-control form-control-lg text-center" maxlength="6" name="otp" placeholder="Enter OTP" required="" autofocus="">
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Veirfy OTP</button>
                            </div>
                        </div>
                    </div>


                <?php elseif ($Self->data['paystep'] == 4) : ?>

                    <!-- page content here -->
                    <h6 class="subtitle">Transaction Details</h6>
                    <div class="row container">
                        <div class="col-12 px-0">
                            <ul class="list-group list-group-flush border-top border-bottom">
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1">Transfer Amount</h6>
                                            <p class="text-mute small text-secondary">all funds are in <?= $UserInfo->currency ?></p>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="text-success"><?= $Banco->Monify($Self->data['PayData']['amount']) ?></h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1">Beneficiary Name</h6>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="text-default"><?= $Self->data['PayData']['name'] ?></h6>
                                        </div>
                                    </div>
                                </li>


                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1">Beneficiary Account Number</h6>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="text-default"><?= $Self->data['PayData']['accno'] ?></h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1">Beneficiary Account Name</h6>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="text-default"><?= $Self->data['PayData']['accname'] ?></h6>
                                        </div>
                                    </div>
                                </li>


                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1">Beneficiary Bank Name</h6>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="text-default"><?= $Self->data['PayData']['bankname'] ?></h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1">Beneficiary Bank Address</h6>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="text-default"><?= $Self->data['PayData']['bankaddress'] ?></h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1">Beneficiary Swift Code</h6>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="text-default"><?= $Self->data['PayData']['swiftcode'] ?></h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1">Beneficiary IBAN</h6>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="text-default"><?= $Self->data['PayData']['iban'] ?></h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col align-self-center pr-0">
                                            <h6 class="font-weight-normal mb-1">Beneficiary ABA/Routing Number</h6>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="text-default"><?= $Self->data['PayData']['abaroutine'] ?></h6>
                                        </div>
                                    </div>
                                </li>


                            </ul>
                        </div>
                    </div>
                    <!-- page content ends -->
                    <button class="btn btn-lg btn-default text-white btn-block btn-rounded shadow mt-3"><span>Complete Transfer</span></button>
                    <br>

                <?php elseif ($Self->data['paystep'] == 5) : ?>

                    <div class="text-center mt-5 w-100" role="document">
                        <h6 class="subtitle">Procesing Transfer <br /><small>this will take a few minutes</small></h6>
                        <div class="form-group mt-4">
                            <img src="<?= $assets ?>/dashboard/img/2.svg" alt="Procesing Transfer...">
                        </div>
                    </div>

                <?php elseif ($Self->data['paystep'] == 6) : ?>

                    <?php if ($UserInfo->transfer_error == "taxcode") : ?>
                        <input type="hidden" name="transfer_error" value="taxcode">
                        <div class="modal-dialog modal-sm modal-dialog-centered mt-0" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center pt-0">
                                    <h6 class="subtitle">TAX Verification & Clearance Code<br /><small>kindly enter your Tax Clearance Code</small></h6>
                                    <button class="btn btn-default btn-rounded-54 shadow"><i class="material-icons">fingerprint</i></button>
                                    <div class="form-group mt-4">
                                        <input type="text" class="form-control form-control-lg text-center" maxlength="12" name="error_code" placeholder="Enter Tax Clearance Code" required="" autofocus="">
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Veirfy Tax Clearance</button>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($UserInfo->transfer_error == "aml") : ?>
                        <input type="hidden" name="transfer_error" value="aml">
                        <div class="modal-dialog modal-sm modal-dialog-centered mt-0" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center pt-0">
                                    <h6 class="subtitle">Anti-Money Laundering Certificate Code <br /><small>kindly enter your AML Certificate Code</small></h6>
                                    <button class="btn btn-default btn-rounded-54 shadow"><i class="material-icons">fingerprint</i></button>
                                    <div class="form-group mt-4">
                                        <input type="text" class="form-control form-control-lg text-center" maxlength="12" name="error_code" placeholder="Enter AMLC Code" required="" autofocus="">
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Veirfy AMLC Code</button>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($UserInfo->transfer_error == "uvc") : ?>
                        <input type="hidden" name="transfer_error" value="uvc">
                        <div class="modal-dialog modal-sm modal-dialog-centered mt-0" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center pt-0">
                                    <h6 class="subtitle">Universal Verification Code <br /><small>kindly enter your UVC Code</small></h6>
                                    <button class="btn btn-default btn-rounded-54 shadow"><i class="material-icons">fingerprint</i></button>
                                    <div class="form-group mt-4">
                                        <input type="text" class="form-control form-control-lg text-center" maxlength="12" name="error_code" placeholder="Enter UVC Code" required="" autofocus="">
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Veirfy UVC Code</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php elseif ($Self->data['paystep'] == 7) : ?>

                    <div class="text-center mt-5 w-100" role="document">
                        <h6 class="subtitle">Procesing Transfer <br /><small>this will take a few minutes</small></h6>
                        <div class="form-group mt-4">
                            <img src="<?= $assets ?>/dashboard/img/2.svg" alt="Procesing Transfer...">
                        </div>
                    </div>

                <?php endif; ?>


            <?php endif; ?>

        </div>


        <!-- footer-->
        <div class="footer">
            <div class="no-gutters">
                <div class="col-auto mx-auto">
                    <div class="row no-gutters justify-content-center">
                        <div class="col-auto">
                            <a href="/" class="btn btn-link-default">
                                <i class="material-icons">home</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="/activities/" class="btn btn-link-default">
                                <i class="material-icons">insert_chart_outline</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="/transactions/" class="btn btn-link-default active">
                                <i class="material-icons">account_balance_wallet</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="/profile" class="btn btn-link-default">
                                <i class="material-icons">account_circle</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="/auth/logout" class="btn btn-link-default">
                                <i class="material-icons">power_settings_new</i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer ends-->


    </div>
</form>