<?php if ($Self->auth) : ?>
    <!-- color chooser menu start -->
    <div class="modal fade " id="colorscheme" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header theme-header border-0">
                    <h6 class="">Color Picker</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center theme-color">
                        <button class="m-1 btn red-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="red-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn blue-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="blue-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn yellow-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="yellow-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn green-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="green-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn pink-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="pink-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn orange-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="orange-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn purple-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="purple-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn deeppurple-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="deeppurple-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn lightblue-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="lightblue-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn teal-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="teal-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn lime-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="lime-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn deeporange-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="deeporange-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn gray-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="gray-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                        <button class="m-1 btn black-theme-bg text-white btn-rounded-54 shadow-sm" data-theme="black-theme"><i class="material-icons w-50">color_lens_outline</i></button>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-6 text-left">
                        <div class="row">
                            <div class="col-auto text-right align-self-center"><i class="material-icons text-warning vm">wb_sunny</i></div>
                            <div class="col-auto text-center align-self-center px-0">
                                <div class="custom-control custom-switch float-right">
                                    <input type="checkbox" name="themelayout" class="custom-control-input" id="theme-dark">
                                    <label class="custom-control-label" for="theme-dark"></label>
                                </div>
                            </div>
                            <div class="col-auto text-left align-self-center"><i class="material-icons text-dark vm">brightness_2</i></div>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <div class="row">
                            <div class="col-auto text-right align-self-center">LTR</div>
                            <div class="col-auto text-center align-self-center px-0">
                                <div class="custom-control custom-switch float-right">
                                    <input type="checkbox" name="rtllayout" class="custom-control-input" id="theme-rtl">
                                    <label class="custom-control-label" for="theme-rtl"></label>
                                </div>
                            </div>
                            <div class="col-auto text-left align-self-center">RTL</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- color chooser menu ends -->

    <!-- Modal addmoney -->
    <div class="modal fade" id="addmoney" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">

                <form class="m-0" action="/banco/dashboard/sendmoney" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="startpay" id="startpay" value="1">
                    <?= $Self->tokenize() ?>
                    <div class="modal-header border-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center pt-0">
                        <button class="btn btn-default btn-rounded-54 shadow"><i class="material-icons">account_balance_wallet</i></button>
                        <div class="form-group mt-4">
                            <input type="number" class="form-control form-control-lg text-center" name="amount" min="500" max="<?= $UserInfo->balance ?>" placeholder="Enter amount" required="" autofocus="">
                        </div>
                        <p class="text-mute">Enter amount in <?= $UserInfo->currency ?>.</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Continue</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Modal addmoney -->

    <!-- Modal addmoney -->
    <div class="modal fade" id="statement" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">

                <form class="m-0" action="/ibanking/statement/<?= $UserInfo->accid ?>/print" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="startpay" id="startpay" value="1">
                    <?= $Self->tokenize() ?>
                    <div class="modal-header border-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center pt-0">
                        <button class="btn btn-default btn-rounded-54 shadow"><i class="material-icons">account_balance_wallet</i></button>
                        <div class="form-group mt-4">
                            Request Statement
                        </div>
                        <p class="text-mute">Your up to date account statement will be emailed to you.</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-default btn-lg btn-rounded shadow btn-block">Request Financial Statement</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Modal addmoney -->
<?php endif; ?>



<!-- jquery, popper and bootstrap js -->
<script src="<?= $assets ?>/dashboard/js/jquery-3.3.1.min.js"></script>
<script src="<?= $assets ?>/dashboard/js/popper.min.js"></script>
<script src="<?= $assets ?>/dashboard/vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script>
<!-- swiper js -->
<script src="<?= $assets ?>/dashboard/vendor/swiper/js/swiper.min.js"></script>
<!-- cookie js -->
<script src="<?= $assets ?>/dashboard/vendor/cookie/jquery.cookie.js"></script>
<!-- template custom js -->
<script src="<?= $assets ?>/dashboard/js/main.js"></script>
<!-- page level script -->
</body>

</html>