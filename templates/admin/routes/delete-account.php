<div class="container-fluid">
   <div class="col-xl-12 col-12">
      <div class="card">
         <div class="card-header">
            <h4 class="card-title">Profile Information for: <?= "{$AccountInfo->firstname} {$AccountInfo->lastname}" ?></h4>
            <a type="button" href="/admin/accounts" class="btn btn-rounded btn-info float-right btn-md"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i></span>Manage Accounts</a>
         </div>
         <div class="card-body">

            <div class="container">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="panel panel-bd lobidrag">
                        <div class="panel-body">
                           <form action="/ajax/delete-account" method="post" enctype="multipart/form-data">

                              <input type="hidden" name="accid" value="<?= $AccountInfo->accid ?>" />

                              <div class="row">
                                 <div class="col-md-12 form-group text-center">
                                    <p><em>Are you sure you want to delete this Bank Account Holder?</em></p>
                                    <label for="title">
                                       <h1><?= "{$AccountInfo->firstname} {$AccountInfo->lastname} ({$AccountInfo->accid})" ?></h1>
                                    </label>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-4"></div>
                                 <div class="col-md-4 form-group">
                                    <button type="submit" class="btn btn-danger" style="margin-top:10px;">Yes, Delete Account</button>
                                 </div>
                                 <div class="col-md-4"></div>
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