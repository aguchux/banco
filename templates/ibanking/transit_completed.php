<form class="m-0" action="/banco/dashboard/sendmoney" enctype="multipart/form-data" method="POST">
    <?= $Self->tokenize() ?>
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

            <div class="jumbotron mb-3 mt-5 bg-success text-white text-center">
                <h4 class="text-white mb-3">Transfer was Successful</h4>
                <p class="lead">Thank you, your transfer was successfully executed.</p>
                <hr class="my-4">
                <p>International tranfers might take up to 72 hours to complete.</p>
                <br>
                <a class="btn btn-primary" href="/ibanking" role="button">Back To Dashboard</a>
            </div>
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
                            <a href="/transactions/" class="btn btn-link-default active">
                                <i class="material-icons">account_balance_wallet</i>
                            </a>
                        </div>
                        <div class="col-auto">
                            <a href="/profile" class="btn btn-link-default">
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
</form>