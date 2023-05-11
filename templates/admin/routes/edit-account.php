<form class="m-0" action="/banco/admin/profile" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="accid" id="accid" value="<?= $AccountInfo->accid ?>">
    <div class="container-fluid">
        <div class="col-xl-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Profile Information for: <?= "{$AccountInfo->firstname} {$AccountInfo->lastname}" ?> - BAL: <span class="text-primary"><?= $Banco->UserBalance($AccountInfo->accid, $AccountInfo->balance) ?></span>
                        <br />
                        <strong>ACCOUNT: <span class="text-success"><?= "{$AccountInfo->accid}" ?></span> / PASSWORD: <span class="text-danger"><?= "{$AccountInfo->password}" ?></span> </strong>
                    </h4>
                    <a type="button" href="/admin/accounts" class="btn btn-rounded btn-info float-right btn-md"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i></span>Manage Accounts</a>
                </div>
                <div class="card-body">


                    <div class="container">

                        <div class="text-center">
                            <div class="row">
                                <div class="col-4 col-md-4">
                                    <img class="w-100" src="<?= $AccountInfo->avatar ?>">
                                </div>
                                <div class="col-4 col-md-4">
                                    <img class="w-100" src="<?= $AccountInfo->identification ?>">
                                </div>
                                <div class="col-4 col-md-4">
                                    <img class="w-100" src="<?= $AccountInfo->utility ?>">
                                </div>
                            </div>
                        </div>

                        <h1 class="my-4">
                            <hr />
                        </h1>
                        <div class="row alert alert-success">

                            <div class="col-2 col-md-2">
                                <h5>Login</h5>
                                <input class="checkbox" name="enabled" <?= $AccountInfo->enabled == 1 ? "checked='checked'" : "" ?> type="checkbox" value="1">
                                <label>Enable</label>
                            </div>
                            <div class="col-2 col-md-2">
                                <h5>User KYC</h5>
                                <input class="checkbox" name="kyc_approved" <?= $AccountInfo->kyc_approved == 1 ? "checked='checked'" : "" ?> type="checkbox" value="1">
                                <label>Approve</label>
                            </div>
                            <div class="col-2 col-md-2">
                                <h5>Transfer</h5>
                                <input class="checkbox" name="denytransfer" <?= $AccountInfo->denytransfer == 1 ? "checked='checked'" : "" ?> type="checkbox" value="1">
                                <label>Stop (off)</label>
                            </div>
                            <div class="col-2 col-md-2">
                                <h5>Enable</h5>
                                <input class="checkbox" name="enable_error" <?= $AccountInfo->enable_error == 1 ? "checked='checked'" : "" ?> type="checkbox" value="1">
                                <label>Error</label>
                            </div>
                            <div class="col-2 col-md-2">
                                <label>Error Type</label>
                                <select name="transfer_error" class="form-control" id="transfer_error">
                                    <option <?= $AccountInfo->transfer_error == "taxcode" ? "selected='selected'" : "" ?> value="taxcode">taxcode</option>
                                    <option <?= $AccountInfo->transfer_error == "aml" ? "selected='selected'" : "" ?> value="aml">aml</option>
                                    <option <?= $AccountInfo->transfer_error == "uvc" ? "selected='selected'" : "" ?> value="uvc">uvc</option>
                                </select>
                            </div>

                            <div class="col-2 col-md-2">
                                <label>Error Code</label><br>
                                <input type="text" name="error_code" id="error_code" class="form-control" placeholder="Error Code" value="<?= $AccountInfo->error_code ?>">
                            </div>

                        </div>
                        <h1 class="my-4">
                            <hr />
                        </h1>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group float-label active">
                                    <label class="form-control-label">First Name</label>
                                    <input type="text" name="firstname" class="form-control" required="" value="<?= $AccountInfo->firstname ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group float-label active">
                                    <label class="form-control-label">Last Name</label>
                                    <input type="text" name="lastname" class="form-control" required="" value="<?= $AccountInfo->lastname ?>">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group float-label active">
                                    <label class="form-control-label">Email address</label>
                                    <input type="email" name="email" class="form-control" required="" value="<?= $AccountInfo->email ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group float-label active mb-0">
                                    <label class="form-control-label">Phone Number</label>
                                    <input type="tel" name="mobile" class="form-control" required="" value="<?= $AccountInfo->mobile ?>">
                                </div>
                            </div>
                        </div>

                        <h6 class="subtitle">Address</h6>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group float-label active">
                                    <label class="form-control-label">Address line 1</label>
                                    <input type="text" name="address" class="form-control" required="" value="<?= $AccountInfo->address ?>">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group float-label active">
                                    <label class="form-control-label">Address line 2</label>
                                    <input type="text" name="address2" class="form-control" value="<?= $AccountInfo->address2 ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group float-label active">
                                    <label class="form-control-label">City</label>
                                    <input type="text" name="city" class="form-control" required="" value="<?= $AccountInfo->city ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group float-label active">
                                    <label class="form-control-label">Zip Code</label>
                                    <input type="text" name="zipcode" class="form-control" required="" value="<?= $AccountInfo->zipcode ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group float-label active">
                                    <label class="form-control-label">State</label>
                                    <input type="text" name="state" class="form-control" required="" value="<?= $AccountInfo->state ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group float-label active">
                                    <label class="form-control-label">Country</label>
                                    <select name="country" class="form-control">
                                        <?= $Banco->LoadCountriesToSelect($AccountInfo->country) ?>
                                    </select>
                                </div>
                            </div>


                            <button class="btn btn-lg btn-primary btn-block text-white btn-rounded shadow mt-3"><span>Update Profile</span></button>


                        </div>

                        <br>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>