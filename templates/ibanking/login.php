<div class="wrapper">
    <form class="form-signin mt-0" action="/banco/auth/login" method="POST">

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
                <img src="https://www.citizensbcanada.com/assets/images/logo.png" style="width:200px" class="mb-4" alt="Citizens Bank Canada" class="logo-small">
                <?= $Self->tokenize() ?>
                <?= $Self->Toast() ?>
                <div class="form-group">
                    <input type="text" id="username" name="username" required aria-required="true" class="form-control form-control-lg text-center" placeholder="Account Number" autofocus="">
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="password" required aria-required="true" class="form-control form-control-lg text-center" placeholder="Password">
                </div>

                <div class="row">
                    <div class="col-6 text-left"><a href="/auth/register" class="mt-4 d-block">Create Account</a></div>
                    <div class="col-6 text-right"><a href="/auth/reset" class="mt-4 d-block">Reset Password?</a> </div>
                </div>
            </div>
        </div>

        <!-- login buttons -->
        <div class="row mx-0 bottom-button-container">
            <div class="col">
                <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Login</button>
            </div>
        </div>
        <!-- login buttons -->

    </form>
</div>