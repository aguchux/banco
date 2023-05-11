<div class="wrapper">

    <form class="form-signin mt-0" action="/banco/auth/register" method="POST" autocomplete="off" enctype="multipart/form-data">

        <!-- header -->
        <div class="header">
            <div class="row no-gutters">
                <div class="col-auto">
                    <a href="/" class="btn  btn-link text-dark"><i class="material-icons">chevron_left</i></a>
                </div>
                <div class="col text-center"></div>
                <div class="col-auto">
                </div>
            </div>
        </div>
        <!-- header ends -->

        <div class="row no-gutters login-row">
            <div class="col align-self-center px-3 text-center">
                <br>
                <img src="<?= $assets ?>/dashboard/img/logo-login.png" class="mb-4" alt="Landmark Finance Bank" class="logo-small mb-3">
                <?= $Self->tokenize() ?>
                <?= $Self->Toast() ?>
                <?php if (!isset($Self->data['regstep'])) : ?>

                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <select name="sex" id="sex" class="form-control" required="">
                                    <option value=""></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select> <label class="form-control-label">Gender</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="email" name="email" class="form-control" required="">
                                <label class="form-control-label">Email Address</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="tel" name="mobile" class="form-control" required="">
                                <label class="form-control-label">Telephone Number</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="text" name="firstname" class="form-control" required="">
                                <label class="form-control-label">First Name</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group float-label">
                                <input type="text" name="lastname" class="form-control" required="">
                                <label class="form-control-label">Last Name</label>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12 text-center"><a href="/ibanking/auth/login" class="mt-4 d-block">Already register? Login</a></div>
                    </div>

                <?php else : ?>


                    <?php if ($Self->data['regstep'] == 1) : ?>



                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-group float-label">
                                    <input type="text" name="address" class="form-control" required="">
                                    <label class="form-control-label">Address line 1</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group float-label">
                                    <input type="text" name="address2" class="form-control">
                                    <label class="form-control-label">Address line 2</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-group float-label">
                                    <select id="country" name="country" class="form-control" required="">
                                        <option value="" selected></option>
                                        <?= $Banco->LoadCountriesToSelect() ?>
                                    </select>
                                    <label class="form-control-label">Select Country</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group float-label">
                                    <input type="text" name="state" class="form-control" required="">
                                    <label class="form-control-label">State</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group float-label">
                                    <input type="text" name="city" class="form-control" required="">
                                    <label class="form-control-label">City</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group float-label">
                                    <input type="text" name="zipcode" class="form-control" required="">
                                    <label class="form-control-label">Zip Code</label>
                                </div>
                            </div>

                        </div>

                    <?php elseif ($Self->data['regstep'] == 2) : ?>
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="text-center">
                                    <div class="figure-profile shadow my-4">
                                        <figure><img src="./_store/avatars/user.png"></figure>
                                    </div>
                                    <input class="mx-auto" type="file" name="avatar" id="avatar" required>
                                    <h6 class="subtitle my-3">Upload A Clear Profile Photo</h6>
                                </div>
                            </div>
                        </div>

                    <?php elseif ($Self->data['regstep'] == 3) : ?>

                        <div class="row">


                            <div class="col-12 col-md-12">
                                <div class="form-group float-label">
                                    <select id="currency" name="currency" class="form-control" required="">
                                        <option value="" selected></option>
                                        <?= $Banco->LoadCurrenciesToSelect() ?>
                                    </select>
                                    <label class="form-control-label">Select Domiciliary Currency </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12">
                                <div class="form-group float-label">
                                    <select id="account_type" name="account_type" class="form-control" required="">
                                        <option value="" selected></option>
                                        <option value="Savings Account">Savings Account</option>
                                        <option value="Current Account">Current Account</option>
                                        <option value="Investment Account">Investment Account</option>
                                        <option value="Trust Account">Trust Account</option>
                                        <option value="Platinum Business Account">Platinum Business Account</option>
                                        <option value="Gold Business Account">Gold Business Account</option>
                                        <option value="Loan Account">Loan Account</option>
                                    </select>
                                    <label class="form-control-label">Select Account Type</label>
                                </div>
                            </div>



                        </div>

                    <?php elseif ($Self->data['regstep'] == 4) : ?>

                        <div class="row">

                            <div class="col-12 col-md-12 px-2">
                                <h3 class="subtitle">Upload Identification Document</h3>
                                <img src="./_store/accounts/kyc/identification.png" class="mb-3 w-100">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="identification" name="identification" required="">
                                    <label class="custom-file-label" for="identification">Select Document...</label>
                                </div>
                            </div>

                        </div>
                    <?php elseif ($Self->data['regstep'] == 5) : ?>

                        <div class="row">

                            <div class="col-12 col-md-12 px-2">
                                <h3 class="subtitle">Upload Utility (Address) Document</h3>
                                <img src="./_store/accounts/kyc/utility.png" class="mb-3 w-100">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="utility" name="utility" required="">
                                    <label class="custom-file-label" for="utility">Select Document...</label>
                                </div>
                            </div>

                        </div>
                    <?php elseif ($Self->data['regstep'] == 6) : ?>

                        <div class="row">

                            <div class="col-12 col-md-12 px-2 text-center mt-4 d-block text-secondary">
                                <h3 class="subtitle">ACCOUNT USE AGREEMENT</h3>
                                <p class="text-muted">By clicking SUBMIT BUTTON below, you agree to all our <a href="javascript:void(0)">Terms and Conditon.</a></p>
                            </div>

                        </div>

                    <?php endif; ?>

                <?php endif; ?>


            </div>
        </div>

        <!-- login buttons -->
        <div class="row mx-0 bottom-button-container">
            <div class="col">
                <?php if (!isset($Self->data['regstep'])) : ?>
                    <button class="btn btn-default btn-lg btn-rounded shadow btn-block">Next Step</button>
                <?php else : ?>
                    <?php if ($Self->data['regstep'] == 6) : ?>
                        <button class="btn btn-default btn-lg btn-rounded shadow btn-block">Submit Your Application</button>
                    <?php else : ?>
                        <div class="row">
                            <div class="col-12 col-md-6"><a href="/ibanking/auth/register/previous" class="btn btn-default btn-lg btn-rounded shadow btn-block">Go Back</a></div>
                            <div class="col-12 col-md-6"><button class="btn btn-default btn-lg btn-rounded shadow btn-block">Next Step</button></div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <!-- login buttons -->
    </form>

</div>