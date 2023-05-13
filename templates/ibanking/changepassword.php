<div class="wrapper">
    <form class="form-signin mt-0" action="/banco/auth/changepassword" method="POST">

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
            <div class="col align-self-center px-auto text-center">
                <br>
                <img src="<?= $assets ?>/dashboard/img/logo-login.png" alt="Citizens Bank Canada" class="logo-small">
                <?= $Self->tokenize() ?>
                <?= $Self->Toast() ?>
                <div class="col-12 col-md-12 mx-auto text-center">
                    <h4 class="mt-5"><span class="font-weight-light">Change </span>Password</h4>
                    <br>
                    <div class="form-group float-label">
                        <input type="password" id="oldpass" name="oldpass" class="form-control form-control-lg" required="">
                        <label for="oldpass" class="form-control-label">Current Password</label>
                    </div>
                    <div class="form-group float-label">
                        <input type="password" id="newpass" name="newpass" class="form-control form-control-lg" required="">
                        <label for="newpass" class="form-control-label">New Password</label>
                    </div>
                    <div class="form-group float-label">
                        <input type="password" id="newpass1" name="newpass1" class="form-control form-control-lg" required="">
                        <label for="newpass1" class="form-control-label">Confirm New Password</label>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <button type="submit" class="btn btn-lg btn-default btn-block btn-rounded shadow"><span>Update Password</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>



    
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
                            <a href="/transactions/" class="btn btn-link-default">
                                <i class="material-icons">account_balance_wallet</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="/profile" class="btn btn-link-default active">
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