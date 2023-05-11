<div class="wrapper">

    <!-- header -->
    <div class="header">
        <div class="row no-gutters">
            <div class="col-auto">
                <a href="/ibanking/" onclick="window.history.go(-1); return false;" class="btn  btn-link text-dark"><i class="material-icons">navigate_before</i></a>
            </div>
            <div class="col text-center"><img src="<?= $assets ?>/dashboard/img/logo-header.png" class="header-logo"></div>
            <div class="col-auto">
                <a href="/ibanking/transactions" class="btn  btn-link text-dark position-relative"><i class="material-icons">notifications_none</i><span class="counts"><?= $Banco->CountTransactions() ?>+</span></a>
            </div>
        </div>
    </div>
    <!-- header ends -->

    <div class="container">
        <div class="card bg-template shadow mt-4 h-150">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="mb-0 font-weight-normal"><?= $Banco->Balance($UserInfo->balance) ?></h3>
                        <p class="text-mute">My Account Balance</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-default btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"><i class="material-icons">account_balance_wallet</i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container top-50">
        <div class="card mb-4 shadow">
            <div class="card-body bg-none py-3">
                <div class="row">
                    <div class="col text-right">
                        <p><?= $Banco->MonifyDebits() ?> <i class="material-icons text-success vm small">arrow_upward</i><br><small class="text-mute">All Income</small></p>
                    </div>
                    <div class="col border-left-dotted">
                        <p><i class="material-icons text-danger vm small mr-1">arrow_downward</i> <?= $Banco->MonifyCredits() ?><br><small class="text-mute">All Expenses</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <input type="text" class="form-control form-control-lg search my-3 disabled" disabled placeholder="Search">
        <!-- page content here -->
        <h6 class="subtitle">All Transactions</h6>
        <div class="row">
            <div class="col-12 px-0">
                <ul class="list-group list-group-flush border-top border-bottom">
                    <?php while ($transaction = mysqli_fetch_object($RecentTransactions)) :
                        $Color = "success";
                        if ($transaction->type == "DEBIT" || $transaction->type == "FEES") {
                            $Color = "danger";
                        } elseif ($transaction->type == "CREDIT" || $transaction->type == "RESERVE") {
                            $Color = "success";
                        } ?>
                        <li class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto pr-0">
                                    <button class="btn btn-default btn-rounded-40 shadow"><i class="material-icons">local_atm</i></button>
                                </div>
                                <div class="col align-self-center pr-0">
                                    <h6 class="font-weight-normal mb-1"><?= $transaction->notes ?></h6>
                                    <p class="text-mute small text-secondary"><?= $transaction->created ?></p>
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-<?= $Color ?>"><?= $Banco->Monify($transaction->amount) ?></h6>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>

                </ul>
            </div>
        </div>
        <!-- page content ends -->
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
                        <a href="/ibanking/transactions/" class="btn btn-link-default active">
                            <i class="material-icons">account_balance_wallet</i>
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="/ibanking/profile" class="btn btn-link-default">
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