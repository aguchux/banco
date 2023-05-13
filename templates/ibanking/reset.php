<div class="wrapper">

    <form class="form-signin mt-0" action="/banco/auth/reset" method="POST">
        <?= $Self->tokenize() ?>
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
                <br>
                <img src="<?= $assets ?>/dashboard/img/logo-login.png" alt="Citizens Bank Canada" class="logo-small">
                <form class="form-signin mt-3" action="/banco/auth/reset" method="POST">
                    <?= $Self->tokenize() ?>
                    <?= $Self->Toast() ?>
                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control form-control-lg text-center" placeholder="Account Number OR Email" required aria-required="true" autofocus="">
                    </div>
                    <p class="text-secondary mt-4 d-block">If you already have password,<br>please <a href="/auth/login" class="">Sign in</a> here</p>

            </div>
        </div>

        <!-- login buttons -->
        <div class="row mx-0 bottom-button-container">
            <div class="col">
                <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Reset Password</button>
            </div>
        </div>
        <!-- login buttons -->

    </form>

</div>