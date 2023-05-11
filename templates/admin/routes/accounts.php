<div class="container-fluid">
   <div class="col-xl-12 col-12">
      <div class="card">
         <div class="card-header">
            <h4 class="card-title">All Accounts & Users</h4>
            <a type="button" href="/admin/accounts" class="btn btn-rounded btn-info float-right btn-md"><span class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i></span>Manage Accounts</a>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table id="example" class="display" style="min-width: 845px">
                  <thead>
                     <tr>


                        <th>ACCID</th>
                        <th>NAME</th>
                        <th>BALANCE</th>
                        <th><i class="fa fa-pencil" aria-hidden="true"></i></th>

                     </tr>
                  </thead>
                  <tbody>

                     <? while ($account = mysqli_fetch_object($accounts)) : ?>
                        <tr>
                           <td><?= $account->accid; ?></td>
                           <td><?= "{$account->firstname} {$account->lastname}" ?></td>
                           <td><?= $Banco->UserBalance($account->accid, $account->balance) ?></td>
                           <td>
                              <div class="d-flex">
                                 <a href="/admin/fund-account/account/<?= $account->accid; ?>/fund" class="btn btn-success shadow btn-xs  mr-1"><i class="fa fa-plus"></i> Fund</a>
                                 <a href="/admin/edit-account/account/<?= $account->accid; ?>/edit" class="btn btn-success shadow btn-xs  mr-1"><i class="fa fa-eye"></i> View</a>
                                 <a href="/admin/info-account/account/<?= $account->accid; ?>/info" class="btn btn-success shadow btn-xs  mr-1">Transactions</a>
                                 <a href="/admin/delete-account/account/<?= $account->accid; ?>/delete" class="btn btn-danger shadow btn-xs  mr-1"><i class="fa fa-trash"></i></a>
                                
                                 <?php if($account->new_account): ?>
                                 <a href="/admin/approve-account/<?= $account->accid; ?>/" class="btn btn-primary shadow btn-xs">Approve</a>
                                 <?php endif; ?>

                              </div>
                           </td>
                        </tr>
                     <? endwhile; ?>

                  </tbody>
                  <tfoot>
                     <tr>
                        <th>ACCID</th>
                        <th>NAME</th>
                        <th>BALANCE</th>
                        <th><i class="fa fa-pencil" aria-hidden="true"></i></th>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>