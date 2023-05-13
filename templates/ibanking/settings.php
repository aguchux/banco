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
        <form class="m-0" action="/banco/dashboard/settings" enctype="multipart/form-data" method="POST">
            <?= $Self->tokenize() ?>
            <div class="row ">
                <div class="col-12 px-0">
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">Email One Time Password (SMS & Email)</h6>
                                    <p class="text-secondary mb-0 small">Enabel OTP on activities</p>
                                </div>
                                <div class="col-2 pl-0 align-self-center text-right">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="otp_enabled" value="1" name="otp_enabled" <?= $UserInfo->otp_enabled ? "checked=''" : "" ?>>
                                        <label class="custom-control-label" for="otp_enabled"></label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">Email Notification</h6>
                                    <p class="text-secondary mb-0 small">Default all notification will be sent</p>
                                </div>
                                <div class="col-2 pl-0 align-self-center text-right">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="email_notix" value="1" name="email_notix" <?= $UserInfo->email_notix ? "checked=''" : "" ?>>
                                        <label class="custom-control-label" for="email_notix"></label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">SMS Notification</h6>
                                    <p class="text-secondary mb-0 small">Receive SMS notification</p>
                                </div>
                                <div class="col-2 pl-0 align-self-center text-right">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="sms_notix" value="1" name="sms_notix" <?= $UserInfo->sms_notix ? "checked=''" : "" ?>>
                                        <label class="custom-control-label" for="sms_notix"></label>
                                    </div>
                                </div>
                            </div>
                        </li>


                        <li class="list-group-item">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">Profile Update Notification</h6>
                                    <p class="text-secondary mb-0 small">Receive Email Notification on Profile update</p>
                                </div>
                                <div class="col-2 pl-0 align-self-center text-right">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="profile_notix" value="1" name="profile_notix" <?= $UserInfo->profile_notix ? "checked=''" : "" ?>>
                                        <label class="custom-control-label" for="profile_notix"></label>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <a href="/changepassword" class="row">
                                <div class="col">
                                    <h6 class="text-dark mb-1">Change password</h6>
                                    <p class="text-secondary mb-0 small">You must need your verified email</p>
                                </div>
                                <div class="col-2 pl-0 align-self-center text-right">
                                    <i class="material-icons text-secondary">chevron_right</i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <button class="btn btn-lg btn-default text-white btn-block btn-rounded shadow mt-3"><span>Update Settings</span></button>
            <br>

        </form>


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