<?php
$Banco = new Apps\Banco;
$accid = $Self->storage("accid");
$UserInfo = $Core->UserInfo($accid);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <base href="<?= domain ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= $title ?></title>

    <link href="<?= $adminassets ?>/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?= $adminassets ?>/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="<?= $adminassets ?>/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="<?= $adminassets ?>/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <link href="<?= $adminassets ?>/css/style.css" rel="stylesheet">

</head>

<body>


    <div id="main-wrapper">

        <div class="container">
            <div class="col-xl-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Transactions</h4>
                        <a type="button" href="/admin/accounts" class="btn btn-rounded btn-info float-right btn-md"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i></span>Manage Accounts</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>


                                        <th>TRXID</th>
                                        <th>ACCID</th>
                                        <th>AMOUNT</th>
                                        <th>NOTE/REF.</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($transaction = mysqli_fetch_object($Transactions)) :
                                        $Color = "success";
                                        if ($transaction->type == "DEBIT" || $transaction->type == "FEES") {
                                            $Color = "danger";
                                        } elseif ($transaction->type == "CREDIT" || $transaction->type == "RESERVE") {
                                            $Color = "success";
                                        }
                                        $TrxUSer = $Banco->UserInfo($transaction->accid);

                                    ?>
                                        <tr>
                                            <td><?= $transaction->transid; ?></td>
                                            <td><a href="/admin/edit-account/account/<?= $transaction->accid ?>/edit"><?= "{$TrxUSer->firstname} {$TrxUSer->lastname}" ?></a></td>
                                            <td class="text-<?= $Color ?>"><?= $Banco->UserBalance($transaction->accid, $transaction->amount) ?></td>
                                            <td><?= $transaction->notes ?></td>
                                        </tr>
                                    <? endwhile; ?>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>TRXID</th>
                                        <th>ACCID</th>
                                        <th>AMOUNT</th>
                                        <th>NOTE/REF.</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Required vendors -->
    <script src="<?= $adminassets ?>/vendor/global/global.min.js"></script>
    <script src="<?= $adminassets ?>/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?= $adminassets ?>/vendor/bootstrap-datetimepicker/js/moment.js"></script>
    <script src="<?= $adminassets ?>/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

    <script src="<?= $adminassets ?>/vendor/sweetalert2/dist/sweetalert2.min.js"></script>

    <!-- Datatable -->
    <script src="<?= $adminassets ?>/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= $adminassets ?>/js/plugins-init/datatables.init.js"></script>

    <!-- Dashboard 1 -->
    <script src="<?= $adminassets ?>/js/dashboard/dashboard-1.js"></script>
    <script src="<?= $adminassets ?>/js/deznav-init.js"></script>
    <script src="<?= $adminassets ?>/js/custom.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="<?= $adminassets ?>/js/apps.js?var=<?= time() ?>"></script>


</html>