<div class="container-fluid">
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
                                    <td class="text-<?= $Color ?>"><?= $Banco->UserBalance($transaction->accid,$transaction->amount) ?></td>
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