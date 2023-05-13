<div class="wrapper">

    <form class="form-signin mt-0" action="/banco/auth/lock" method="POST" autocomplete="off" enctype="multipart/form-data">

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
                <img src="<?= $assets ?>/dashboard/img/logo-login.png" class="mb-4" alt="Citizens Bank Canada" class="logo-small mb-3">
                <?= $Self->tokenize() ?>

                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="text-center">
                            <div class="figure-profile shadow my-4">
                                <figure><img src="./_store/avatars/user.png"></figure>
                            </div>
                            <p>Congratulations <strong><?= "{$UserInfo->firstname} {$UserInfo->lastname}" ?></strong>!</p>
                            <p>Your application has been submitted. However, our team will begin review of the details and documents you submitted.</p>
                            <p><a href="/auth/lock/reset" class="btn btn-default btn-lg btn-rounded shadow btn-block">Back To Website</a></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 mt-3">

                    </div>
                </div>


            </div>
        </div>

    </form>

</div>