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


    <div class="container top-50">
        <!-- page content here -->
        <h6 class="subtitle">All Activities</h6>
        <div class="row">
            <div class="col-12 px-0">
                <ul class="list-group list-group-flush ">
                    </a>

                    <?php while ($activity = mysqli_fetch_object($LogonActivities)) :

                        $Devices = array(
                            "Tablet" => "tablet_mac",
                            "Mobile" => "phone_iphone",
                            "Computer" => "computer",
                        )

                    ?>
                        <li class="list-group-item border-top text-dark">
                            <div class="row">
                                <div class="col-auto align-self-center">
                                    <i class="material-icons text-template-primary"><?= $Devices[$activity->device] ?></i>
                                </div>
                                <div class="col pl-0">
                                    <div class="row mb-1">
                                        <div class="col">
                                            <p class="mb-0"><?= $activity->os ?></p>
                                        </div>
                                        <div class="col-auto pl-0">
                                            <p class="small text-mute text-trucated mt-1"><?= date("jS F, Y h:i a", strtotime($activity->created)) ?></p>
                                        </div>
                                    </div>
                                    <p class="small text-mute">Logon from <strong><?= $activity->ip ?></strong> on <strong><?= $activity->os ?></strong> device.</p>
                                </div>

                            </div>
                        </li>
                    <?php endwhile; ?>
            </div>
        </div>
    </div>
    <!-- page content ends -->



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