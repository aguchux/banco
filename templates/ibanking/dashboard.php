<div class="wrapper homepage">
    <!-- header -->
    <div class="header">
        <div class="row no-gutters">
            <div class="col-auto">
                <button class="btn  btn-link text-dark menu-btn"><i class="material-icons">menu</i><span class="new-notification bg-success"></span></button>
            </div>
            <div class="col text-center"><img src="https://www.citizensbcanada.com/assets/images/logo.png" class="header-logo"></div>
            <div class="col-auto">
                <a href="/transactions/" class="btn  btn-link text-dark position-relative"><i class="material-icons">notifications_none</i><span class="counts">0</span></a>
            </div>
        </div>
    </div>
    <!-- header ends -->

    <div class="container">
        <div class="card bg-template shadow mt-4 h-190">
            <div class="card-body">
                <div class="row">
                    <div class="col-auto">
                        <figure class="avatar avatar-60"><img src="<?= $UserInfo->avatar ?>" alt="<?= "{$UserInfo->firstname} {$UserInfo->lastname}" ?>"></figure>
                    </div>
                    <div class="col pl-0 align-self-center">
                        <h3 class="float-right m-0 p-0"><span class="text-light"><?= $UserInfo->accid ?></span></h3>
                        <h5 class="mb-1"><?= "{$UserInfo->firstname} {$UserInfo->lastname}" ?></h5>
                        <p class="text-mute small"><?= "{$UserInfo->state}, {$UserInfo->country}" ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container top-100">
        <div class="card mb-4 shadow">
            <div class="card-body border-bottom">
                <div class="row">
                    <div class="col">
                        <h3 class="mb-0 font-weight-normal"><?= $Banco->Balance($UserInfo->balance) ?></h3>
                        <p class="text-mute">Account Balance</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-default btn-rounded-54 shadow" data-toggle="modal" data-target="#addmoney"><i class="material-icons">account_balance_wallet</i></button>
                    </div>
                </div>
            </div>

            <?php if (show_currency_market) : ?>
                <div class="card-footer bg-none">
                    <div class="row">
                        <div class="col">
                            <p><?= $Banco->getRate('USD') ?> <?= $Banco->ShowArrow('USD') ?><br><small class="text-mute">USD</small></p>
                        </div>
                        <div class="col text-center">
                            <p><?= $Banco->getRate('CAD') ?> <?= $Banco->ShowArrow('CAD') ?><br><small class="text-mute">CAD</small></p>
                        </div>
                        <div class="col text-center">
                            <p><?= $Banco->getRate('JPY') ?> <?= $Banco->ShowArrow('JPY') ?><br><small class="text-mute">JPY</small></p>
                        </div>
                        <div class="col text-center">
                            <p><?= $Banco->getRate('AUD') ?> <?= $Banco->ShowArrow('AUD') ?><br><small class="text-mute">AUD</small></p>
                        </div>
                        <div class="col text-center">
                            <p><?= $Banco->getRate('INR') ?> <?= $Banco->ShowArrow('INR') ?><br><small class="text-mute">INR</small></p>
                        </div>
                        <div class="col text-center">
                            <p><?= $Banco->getRate('ZAR') ?> <?= $Banco->ShowArrow('ZAR') ?><br><small class="text-mute">ZAR</small></p>
                        </div>
                        <div class="col text-center">
                            <p><?= $Banco->getRate('EUR') ?> <?= $Banco->ShowArrow('EUR') ?><br><small class="text-mute">EUR</small></p>
                        </div>
                        <div class="col text-right">
                            <p><?= $Banco->ShowArrow('USD') ?> <?= $Banco->getRate('GBP') ?><br><small class="text-mute">GBP</small></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <div class="container">
        <?= $Self->Toast() ?>

        <div class="row mb-2">
            <div class="container px-0">
                <!-- Swiper -->
                <div class="swiper-container two-slide">
                    <div class="swiper-wrapper">
                        <?php while ($card = mysqli_fetch_object($cardCurrencies)) : ?>
                            <div class="swiper-slide">
                                <div class="card shadow border-0">
                                    <div class="card-body">
                                        <div class="row no-gutters h-100">
                                            <div class="col">
                                                <p><?= "{$card->sign} {$card->curr_rate} {$card->code}" ?><br><small class="text-secondary"><?= $card->name ?></small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>


    </div>



    <div class="container">
        <!-- page content here -->
        <h6 class="subtitle">Recent Transaction History</h6>
        <div class="row">
            <div class="col-12 px-0">
                <ul class="list-group list-group-flush border-top border-bottom">
                    <?php while ($transaction = mysqli_fetch_object($RecentTransactions)) :
                        $Color = "success";
                        if ($transaction->type == "DEBIT" || $transaction->type == "FEES") {
                            $Color = "danger";
                        } elseif ($transaction->type == "CREDIT" || $transaction->type == "RESERVE") {
                            $Color = "success";
                        }
                    ?>
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
                        <a href="/" class="btn btn-link-default active">
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