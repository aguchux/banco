<?php
$Banco = new Apps\Banco;
if ($Self->auth) {
    $UserInfo = $Banco->UserInfo($Self->storage('accid'));
    $CurrInfo = $Banco->CurrInfo($UserInfo->currency);
    $cardCurrencies = $Banco->cardCurrencies();
    $RecentTransactions = $Banco->RecentUserTransactions($UserInfo->accid);
    $LogonActivities = $Banco->LogonActivities($UserInfo->accid);
}
?>
<doctype html>
    <html lang="en" class="deeppurple-theme">

    <head>

        <meta charset="utf-8">
        <base href="<?= domain ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    
        <?php
        $transfer_redirect_time = transfer_redirect_time;
        if (isset($Self->data['paystep'])) {
            if ($Self->data['paystep'] == 5) {
                echo " <meta http-equiv=\"refresh\" content=\"{$transfer_redirect_time}; URL=/ibanking/transit\">";
            }elseif($Self->data['paystep'] == 7){
                echo " <meta http-equiv=\"refresh\" content=\"{$transfer_redirect_time}; URL=/ibanking/transit\">";
            }
        }
        ?>

        <title><?= $title ?></title>
        <!-- Material design icons CSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- <link rel="stylesheet" href="<?= $assets ?>/dashboard/vendor/materializeicon/material-icons.css"> -->
        <!-- Roboto fonts CSS -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
        <!-- Bootstrap core CSS -->
        <link href="<?= $assets ?>/dashboard/vendor/bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- Swiper CSS -->
        <link href="<?= $assets ?>/dashboard/vendor/swiper/css/swiper.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?= $assets ?>/dashboard/css/style.css" rel="stylesheet">
    </head>

    <body>

        <!-- Loader -->
        <div class="row no-gutters vh-100 loader-screen">
            <div class="col align-self-center text-white text-center">
                <img src="https://www.citizensbcanada.com/assets/images/logo.png" alt="citizensbcanada">
                <h1 class="mt-3"><span class="font-weight-light ">Citizens</span>Bank</h1>
                <p class="text-mute text-uppercase small">Fincancial Banking</p>
                <div class="laoderhorizontal">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <!-- Loader ends -->

        <?php if ($Self->auth) : ?>
            <div class="sidebar">
                <div class="mt-4 mb-3">
                    <div class="row">
                        <div class="col-auto">
                            <figure class="avatar avatar-60 border-0"><img src="<?= $UserInfo->avatar ?>" alt="<?= "{$UserInfo->firstname} {$UserInfo->lastname}" ?>"></figure>
                        </div>
                        <div class="col pl-0 align-self-center">
                            <h5 class="mb-1"><?= "{$UserInfo->firstname} {$UserInfo->lastname}" ?></h5>
                            <p class="text-mute small"><?= "{$UserInfo->state}, {$UserInfo->country}" ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="list-group main-menu">

                            <a href="/ibanking" class="list-group-item list-group-item-action active"><i class="material-icons icons-raised">home</i>Dashboard</a>
                            <a href="/transactions" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">find_in_page</i>All Transactions</a>

                            <a href="javascript:;" data-toggle="modal" data-target="#addmoney" class="list-group-item list-group-item-action shadow"><i class="material-icons icons-raised">account_balance_wallet<span class="new-notification"></span></i>Send & Receive Money</a>

                            <a href="/profile" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">account_circle</i>Edit Profile</a>
                            <a href="/settings" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">important_devices</i>Settings</a>
                            <a href="/activities" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">notifications</i>Activities</a>

                            <a href="javascript:;" data-toggle="modal" data-target="#statement" class="list-group-item list-group-item-action shadow"><i class="material-icons icons-raised">account_balance_wallet<span class="new-notification"></span></i>Request Statement</a>
                            
                            <?php if ($UserInfo->kyc_approved) : ?>
                                <a href="/kyc" class="list-group-item list-group-item-action"><i class="material-icons icons-raised">account_box</i>KYC Documents</a>
                            <?php endif; ?>
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#colorscheme"><i class="material-icons icons-raised">color_lens</i>Change Theme</a>
                            <a href="/auth/logout" class="list-group-item list-group-item-action"><i class="material-icons icons-raised bg-danger">power_settings_new</i>Logout</a>

                        </div>
                    </div>
                </div>
            </div>
            <a href="javascript:void(0)" class="closesidemenu"><i class="material-icons icons-raised bg-dark ">close</i></a>
        <?php endif; ?>

