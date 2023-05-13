<div class="wrapper">

    <form class="form-signin mt-0" action="/banco/auth/otp" method="POST">

        <!-- header -->
        <div class="header">
            <div class="row no-gutters">
                <div class="col-auto">
                    <a href="/auth/login" class="btn  btn-link text-dark"><i class="material-icons">chevron_left</i></a>
                </div>
                <div class="col text-center"></div>
                <div class="col-auto">
                </div>
            </div>
        </div>
        <!-- header ends -->

        <div class="row no-gutters login-row">
            <div class="col align-self-center px-3 text-center">
                <img src="<?= $assets ?>/dashboard/img/logo-login.png" alt="Citizens Bank Canada" class="logo-small mb-5">
                <?= $Self->tokenize() ?>
                <?= $Self->Toast() ?>
                <div class="form-group">
                    <input type="text" id="otp" name="otp" class="form-control form-control-lg text-center" placeholder="OTP" required aria-required="true" autofocus="">
                </div>
                <p class="mt-4 d-block text-secondary">
                    Please enter above and confirm.
                </p>


            </div>
        </div>

        <!-- login buttons -->
        <div class="row mx-0 bottom-button-container">
            <div class="col">
                <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Confirm OPT</button>
            </div>
        </div>
        <!-- login buttons -->

    </form>

</div>