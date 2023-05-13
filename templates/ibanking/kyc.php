<div class="wrapper">
    <form class="m-0" action="/banco/dashboard/kyc" enctype="multipart/form-data" method="POST">
    <?= $Self->tokenize() ?>
        <!-- header -->
        <div class="header">
            <div class="row no-gutters">
                <div class="col-auto">
                    <a href="/" onclick="window.history.go(-1); return false;" class="btn  btn-link text-dark"><i class="material-icons">navigate_before</i></a>
                </div>
                <div class="col text-center"><img src="https://www.citizensbcanada.com/assets/images/logo.png" class="header-logo"></div>
                <div class="col-auto">
                    <a href="/transactions" class="btn  btn-link text-dark position-relative"><i class="material-icons">notifications_none</i><span class="counts"><?= $Banco->CountTransactions() ?>+</span></a>
                </div>
            </div>
        </div>
        <!-- header ends -->


        <div class="container">
            <!-- page content here -->

            <?php if ($UserInfo->kyc && !$UserInfo->kyc_approved) : ?>
                <div class="row">

                    <div class="col-12 col-md-12 px-2 text-center">

                        <div class="alert alert-primary text-center mt-5" role="alert">
                            <h4 class="alert-heading">KYC Under Review</h4>
                            <p>We are currently reviewing your identification documents, we will activate your account when all is cleared. We will notify you when this is completed.</p>
                            <hr>
                            <p class="mb-0">This usually would take up to 7 Working Days.</p>
                        </div>

                    </div>

                </div>


            <?php else : ?>


                <div class="row">


                    <div class="col-12 col-md-6 px-2">
                        <h3 class="subtitle">Upload Identification Document</h3>
                        <img src="<?= $UserInfo->identification ?>" class="mb-3 w-100">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="identification" name="identification">
                            <label class="custom-file-label" for="identification">Choose Identification Document...</label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 px-2">
                        <h3 class="subtitle">Upload Utility (Address) Document</h3>
                        <img src="<?= $UserInfo->utility ?>" class="mb-3 w-100">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="utility" name="utility">
                            <label class="custom-file-label" for="utility">Choose Utility Document...</label>
                        </div>
                    </div>

                </div>

                <button class="btn btn-lg btn-default text-white btn-block btn-rounded shadow mt-5"><span>Upload KYC Documents</span></button>

            <?php endif; ?>

            <!-- page content ends -->
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