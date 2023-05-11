    <form class="m-0" action="/banco/dashboard/profile" enctype="multipart/form-data" method="POST">
        <?= $Self->tokenize() ?>
        <div class="wrapper">


            <div class="header">
                <div class="row no-gutters">
                    <div class="col-auto">
                        <a href="/ibanking/" onclick="javascript:history.go(-1)" class="btn  btn-link text-dark"><i class="material-icons">navigate_before</i></a>
                    </div>
                    <div class="col text-center"><img src="<?= $assets ?>/dashboard/img/logo-header.png" class="header-logo"></div>
                    <div class="col-auto">
                        <a href="/ibanking/profile" class="btn  btn-link text-dark"><i class="material-icons">account_circle</i></a>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="text-center">
                    <div class="figure-profile shadow my-4">
                        <figure><img src="<?= $UserInfo->avatar ?>"></figure>
                        <div class="btn btn-dark text-white floating-btn">
                            <i class="material-icons">camera_alt</i>
                            <input type="file" name="avatar" class="float-file">
                        </div>
                    </div>
                </div>

                <h6 class="subtitle">Basic Information</h6>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group float-label active">
                            <input type="text" name="firstname" class="form-control" required="" value="<?= $UserInfo->firstname ?>">
                            <label class="form-control-label">First Name</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group float-label active">
                            <input type="text" name="lastname" class="form-control" required="" value="<?= $UserInfo->lastname ?>">
                            <label class="form-control-label">Last Name</label>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group float-label active">
                            <input type="email" name="email" class="form-control" required="" value="<?= $UserInfo->email ?>">
                            <label class="form-control-label">Email address</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group float-label active mb-0">
                            <input type="tel" name="mobile" class="form-control" required="" value="<?= $UserInfo->mobile ?>">
                            <label class="form-control-label">Phone Number</label>
                        </div>
                    </div>
                </div>

                <h6 class="subtitle">Address</h6>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group float-label active">
                            <input type="text" name="address" class="form-control" required="" value="<?= $UserInfo->address ?>">
                            <label class="form-control-label">Address line 1</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group float-label active">
                            <input type="text" name="address2" class="form-control" value="<?= $UserInfo->address2 ?>">
                            <label class="form-control-label">Address line 2</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group float-label active">
                            <input type="text" name="city" class="form-control" required="" value="<?= $UserInfo->city ?>">
                            <label class="form-control-label">City</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group float-label active">
                            <input type="text" name="zipcode" class="form-control" required="" value="<?= $UserInfo->zipcode ?>">
                            <label class="form-control-label">Zip Code</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group float-label active">
                            <input type="text" name="state" class="form-control" required="" value="<?= $UserInfo->state ?>">
                            <label class="form-control-label">State</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group float-label active">
                            <select name="country" class="form-control">
                                <?= $Banco->LoadCountriesToSelect($UserInfo->country) ?>
                            </select>
                            <label class="form-control-label">Country</label>
                        </div>
                    </div>
                </div>


                <button class="btn btn-lg btn-default text-white btn-block btn-rounded shadow mt-3"><span>Update Profile</span></button>

                <br>
            </div>


            <!-- footer-->
            <div class="footer">
                <div class="no-gutters">
                    <div class="col-auto mx-auto">
                        <div class="row no-gutters justify-content-center">
                            <div class="col-auto">
                                <a href="/ibanking/" class="btn btn-link-default">
                                    <i class="material-icons">home</i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="/ibanking/activities/" class="btn btn-link-default">
                                    <i class="material-icons">insert_chart_outline</i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="/ibanking/transactions/" class="btn btn-link-default">
                                    <i class="material-icons">account_balance_wallet</i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="/ibanking/profile" class="btn btn-link-default active">
                                    <i class="material-icons">account_circle</i>
                                </a>
                            </div>
                            <div class="col-auto">
                                <a href="/ibanking/auth/logout" class="btn btn-link-default">
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