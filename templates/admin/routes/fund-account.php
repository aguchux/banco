<div class="container-fluid">
    <div class="col-xl-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Credit/Debit Account for: <?= "{$AccountInfo->firstname} {$AccountInfo->lastname}" ?></h4>
                <a type="button" href="/admin/accounts" class="btn btn-rounded btn-info float-right btn-md"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i></span>Manage Accounts</a>
            </div>
            <div class="card-body">

                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">

                            <p id="asterisk"><span class="star">*</span> Fields marked with asterisk are required.</p>
                            <form action="/ajax/fund-account" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="accid" value="<?= $AccountInfo->accid ?>" />

                                <legend><span>Credit/Debit Account</span></legend>
                                <div class="form-group">
                                    <label class="error">Transaction Date: <span class="star">*</span></label>
                                    <input name="txdate" class="form-control" type="datetime" value="<?= date("Y-m-d g:i:s", time()); ?>" required="required">
                                </div>
                                <div class="form-group">
                                    <label class="error">Amount: <span class="star">*</span></label>
                                    <input name="amount" class="form-control" type="number" placeholder="0.0" required="required">
                                </div>
                                <div class="form-group">
                                    <span class="label">Types:</span>
                                    <div class="multiple">
                                        <input class="radio" name="trtype" type="radio" checked="checked" value="credit" required="required">
                                        <label>Credit Account</label><br>
                                        <input name="trtype" class="radio" type="radio" value="debit" required="required">
                                        <label>Debit Account</label><br>
                                        <input name="trtype" class="radio" type="radio" value="reverse" required="required">
                                        <label>Reverse Fund</label><br>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Support Message: <span class="star">*</span></label>
                                    <input name="notes" class="form-control" type="text" placeholder="Additional Notes" required="required">
                                </div>

                                <div class="formActions clear">
                                    <input id="btnSubmit" class="btn btn-primary" type="submit" value="Execute Transaction">
                                </div>
                            </form>

                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>
</div>
</div>
</div>