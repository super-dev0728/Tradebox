<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div
                class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="typcn typcn-user-outline"></i>
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">
                    <?php echo display('total_user') ?></p>
                <h3 class="card-title fs-18 font-weight-bold"><?php echo (@$total_user ? esc($total_user) : '0'); ?>
                    <small>Person</small>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">
                    <i class="typcn typcn-user-outline text-success mr-2"></i>
                    <a href="<?php echo base_url('admin/users/user_list') ?>" class="warning-link">See All user's</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div
                class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="">$</i>
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('total_roi') ?>
                </p>
                <h3 class="card-title fs-18 font-weight-bold">
                    <small>$</small><?php echo (@$total_roi ? number_format(esc($total_roi), 2) : '0.0'); ?>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">

                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-info card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="">$</i>

                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">
                    <?php echo display('total_commission') ?></p>
                <h3 class="card-title fs-18 font-weight-bold">
                    <small>$</small><?php echo (@$commission ? number_format(esc($commission), 2) : '0.0'); ?>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">

                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div
                class="card-header card-header-danger card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="">$</i>

                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">
                    <?php echo display('total_investment'); ?></p>
                <h3 class="card-title fs-18 font-weight-bold">
                    <small>$</small><?php echo (@$total_investment ? number_format(esc($total_investment), 2) : '0.0'); ?>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-body">
                <div class='row'>
                    <div class='col-sm-8'>
                        <h2 class="fs-18 font-weight-bold mb-0"> Investmen, ROI, Refferal Bonus</h2>
                    </div>
                    <div class="col-sm-4">
                        <?php echo form_open('#', 'id="invest_date_form" name="invest_date_form" '); ?>
                        <select class="form-control basic-single" name="invest_date" id="invest_date">
                            <?php

                            $years =  date("Y", strtotime("-5 year"));
                            $years_now =  date("Y");

                            for ($i = $years_now; $i >= $years; $i--)
                                echo "<option value='" . esc($i) . "'>" . esc($i) . "</option>";
                            ?>

                        </select>
                        <?php echo form_close() ?>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-sm-12 col-md-12">
                        <canvas id="barChart" height="160"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <!--Simple Donut Chart-->
        <div class="card mb-4">
            <div class="card-body">
                <div class='row'>
                    <div class="col-sm-9 col-md-7">
                        <h6 class="fs-17 font-weight-600 mb-0">Deposit,Withdraw & Investment</h6>
                    </div>
                    <div class="col-sm-3 col-md-5">
                        <?php echo form_open('#', 'id="depowith_form" name="depowith_form" '); ?>
                        <select class="form-control basic-single" name="depowith_year" id="depowith_year">
                            <?php
                            $years      =  date("Y", strtotime("-5 year"));
                            $years_now  =  date("Y");
                            for ($i = $years_now; $i >= $years; $i--)
                                echo "<option value='" . esc($i) . "'>" . esc($i) . "</option>";
                            ?>
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-sm-12 col-md-12">
                        <canvas id="pieChart" height="233"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Exchange All Result</h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Exchange Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Deatils</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($exchange as $key => $value) { ?>
                            <tr>
                                <td><?php echo esc($value->user_id); ?></td>
                                <td><?php echo esc($value->transection_type); ?> -
                                    <?php foreach ($cryptocurrency as $keyc => $valuec) {
                                            if ($value->coin_id == $valuec->cid) {
                                                echo esc($valuec->symbol);
                                            }
                                        } ?>
                                </td>
                                <td><?php echo esc($value->usd_amount); ?></td>
                                <td><?php echo date("jS F, Y", strtotime("$value->date_time")); ?></td>
                                <td><a
                                        href='<?php echo base_url("admin/exchange/edit_exchange/$value->ext_exchange_id"); ?>'>Details</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <a href="<?php echo base_url('admin/exchange/exchange_list') ?>">See All | Exchange Request</a>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Withdraw All Pending</h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Modal body load from ajax end-->
                <?php helper('form'); ?>
                <!-- <form action="#">
                    <input type="text" name="testfile">
                </form> -->

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo display('user_id') ?></th>
                                <th><?php echo display('payment_method') ?></th>
                                <th><?php echo display('ip_address') ?></th>
                                <th><?php echo display('amount') ?></th>
                                <th><?php echo display('action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($wrequest)) ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($wrequest as $value) { ?>
                            <tr>
                                <td><?php echo esc($value->user_id); ?></td>
                                <td><?php echo esc($value->method); ?></td>
                                <td><?php echo esc($value->request_ip); ?></td>
                                <td><?php echo esc($value->amount); ?></td>

                                <td>
                                    <a href="<?php echo base_url() ?>/admin/confirm_withdraw?id=<?php echo $value->withdraw_id; ?>&user_id=<?php echo $value->user_id; ?>&set_status=2"
                                        class="btn btn-success btn-sm"><?php echo display('confirm') ?></a>
                                    <a href="<?php echo base_url() ?>/admin/cancel_withdraw?id=<?php echo $value->withdraw_id; ?>&user_id=<?php echo $value->user_id; ?>&set_status=3"
                                        class="btn btn-danger btn-sm"><?php echo display('cancel') ?></a>
                                    <a href="#<?php echo $value->user_id; ?>" class="AjaxModal btn btn-info btn-sm"
                                        data-toggle="modal" data-target="#newModal"> Information</a>
                                </td>

                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <a href="<?php echo base_url() ?>/admin/withdraw/pending_withdraw">See All | Withdraw Panding</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal body load from ajax start-->
<div class="modal fade modal-success" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo display('profile'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td><strong><?php echo display('name'); ?> : </strong></td>
                        <td id="name"></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo display('email'); ?> : </strong></td>
                        <td id="email"></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo display('mobile'); ?> : </strong></td>
                        <td id="phone"></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo display('user_id'); ?> : </strong></td>
                        <td id="user_id"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div>
</div>


<script>
$('#invest_date').on('change', function() {
    $.ajax({
        url: "<?php echo base_url("backend/testajax"); ?>",
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: "post",
        data: {
            id: 3434
        },
        dataType: "JSON",
        success: function(data) {
            console.log(data);
        }
    });
});
</script>


<script src="<?php echo base_url("public/assets/js/custom-new.js") ?>" type="text/javascript"></script> 