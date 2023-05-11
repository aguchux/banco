<div class="wrapper">

    <!-- header -->
    <div class="header">
        <div class="row no-gutters">
            <div class="col-auto"> </div>
            <div class="col text-center"><img src="<?= $assets ?>/dashboard/img/logo-header.png" class="header-logo"></div>
            <div class="col-auto"></div>
        </div>
    </div>
    <!-- header ends -->

    <div class="container">
        <div class="card bg-template shadow mt-4 h-150">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="mb-0 font-weight-normal"><?= "{$UserInfo->firstname} {$UserInfo->lastname}" ?></h3>
                        <p class="text-mute"><?= "{$UserInfo->address} {$UserInfo->zipcode}, {$UserInfo->city}, {$UserInfo->state}, {$UserInfo->country}" ?></p>
                    </div>
                    <div class="col-auto"></div>
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



</div>