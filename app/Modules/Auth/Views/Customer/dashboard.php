<div class="row">

    <div class="col-sm-6">

        <div class="input-group">
            <label class="col-form-label"><?php echo display('affiliate_url'); ?> </label>
            <input type="text" class="form-control" id="copyed"
                value="<?php echo base_url() ?>/register?ref=<?php echo $session->get('user_id') ?>">
            <span class="input-group-btn">
                <button class="btn btn-primary copy" type="button"><?php echo display('copy'); ?></button>
            </span>
        </div>
    </div>

    <?php if (@$level_info->level != NULL and $level_info->level != 0) { ?>

    <div class="col-sm-6 award-img">
        <div class="form-group">
            <a href="<?php echo base_url() ?>/customer/account/mylevel_info"><img
                    src="<?php echo base_url() ?>/assets/award/0<?php echo esc(@$level_info->level); ?>.png"></a>
        </div>
    </div>
    <?php } ?>
</div>
<br>

<div class="social_share">
    <ul>
        <li class="whatsapp"><a href="<?php echo base_url() ?>/customer/account/my_payout">
                <span><?php echo display('my_payout') ?>
                    $<?php echo (@$my_earns ? number_format(esc($my_earns), 2) : '0.0'); ?></span></a></li>
        <li class="facebook"><a href="<?php echo base_url() ?>/customer/account/my_commission">
                <span><?php echo display('commission') ?>
                    $<?php echo (@$commission ? number_format(esc($commission), 2) : '0.0'); ?></span></a></li>
        <li class="twitter"><a href="<?php echo base_url() ?>/customer/account/team_bonus">
                <span><?php echo display('bonus') ?>
                    $<?php echo ($team_bonus ? number_format(esc($team_bonus), 2) : '0.0'); ?></span></a></li>
    </ul>
</div>

<!-- /.Social share -->
<div class="row">

    <div class="col-sm-6 col-md-3">
        <div class="count_panel">
            <div class="stats-title ">
                <h4><?php echo display('withdraw'); ?></h4>
            </div>
            <h1 class="currency_text text-warning">
                $<?php echo (@$withdraw != 0 ? number_format(esc($withdraw), 2) : '0.0'); ?></h1>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="count_panel">
            <div class="stats-title ">
                <h4><?php echo display('team_turnover') ?></h4>
            </div>
            <h1 class="currency_text text-success">
                $<?php echo (@$team_commission != 0 ? number_format(esc($team_commission), 2) : '0.0'); ?></h1>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="count_panel">
            <div class="stats-title ">
                <h4><?php echo display('personal_turnover') ?></h4>
            </div>
            <h1 class="currency_text text-success">
                $<?php echo (@$sponser_commission != 0 ? number_format(esc($sponser_commission), 2) : '0.0'); ?></h1>
        </div>
    </div>


    <div class="col-sm-6 col-md-3">
        <div class="count_panel">
            <div class="stats-title ">
                <h4><?php echo display('balance'); ?></h4>
            </div>
            <h1 class="currency_text text-info"> $<?php echo number_format(esc($balance), 2); ?></h1>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="count_panel">
            <div class="stats-title ">
                <h4><?php echo display('investment'); ?></h4>
            </div>
            <h1 class="currency_text text-info">$<?php echo number_format(esc($investment->total_amount), 2); ?></h1>
        </div>
    </div>


</div>

<div class="row">
    <div class="col-sm-12">
        <h3 class="block_title"><?php echo display('package'); ?></h3>
        <div class="owl-carousel owl-theme">

            <?php if ($package != NULL) {
                $i = 1;
                foreach ($package as $key => $value) {
            ?>

            <div class="item">
                <div class="pricing__item shadow navy__blue_<?php echo $i++; ?>">
                    <h3 class="pricing__title"><?php echo esc($value->package_name); ?></h3>
                    <div class="pricing__price"><span
                            class="pricing__currency">$</span><?php echo esc($value->package_amount); ?></div>
                    <ul class="pricing__feature-list">
                        <li class="pricing__feature"><?php echo display('period'); ?>
                            <span><?php echo esc($value->period); ?> day</span>
                        </li>
                        <li class="pricing__feature">
                            <?php echo display('yearly_roi'); ?><span>$<?php echo esc($value->yearly_roi); ?></span></li>
                        <li class="pricing__feature"><?php echo display('monthly_roi'); ?>
                            <span>$<?php echo esc($value->monthly_roi); ?></span>
                        </li>
                        <li class="pricing__feature"><?php echo display('weekly_roi'); ?>
                            <span>$<?php echo esc($value->weekly_roi); ?></span>
                        </li>
                        <li class="pricing__feature"><?php echo display('daily_roi'); ?>
                            <span>$<?php echo esc($value->daily_roi); ?></span>
                        </li>
                    </ul>
                    <a href="<?php echo base_url('customer/package/confirm_package/' . esc($value->package_id)); ?>"
                        class="pricing__action center-block"><?php echo display('buy'); ?></a>
                </div>
                <!-- /.End of price item -->
            </div>
            <?php }
            } ?>

        </div>
        <!-- /.Packages -->
    </div>
</div>


<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display('my_payout'); ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo display('date'); ?></th>
                                <th><?php echo display('amount'); ?></th>
                                <th><?php echo display('action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($my_payout) {
                                foreach ($my_payout as $key => $value) {
                            ?>

                            <tr>
                                <td><?php echo esc($value->date); ?></td>
                                <td>$<?php echo esc($value->amount); ?></td>
                                <td><a href="<?php echo base_url() ?>/customer/account/my_payout/<?php echo esc($value->earning_id); ?>"
                                        class="btn btn-success btn-xs">View</a></td>
                            </tr>

                            <?php  }
                            } ?>

                        </tbody>
                    </table>
                </div>
                <a href="<?php echo base_url() ?>/customer/account/my_payout">See all | See Payout</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display('sponsor_info'); ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo display('title'); ?></th>
                                        <th><?php echo display('details'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo display('username'); ?></td>
                                        <td><?php echo esc(@$info['sponser_info']->username); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo display('name'); ?></td>
                                        <td><?php echo esc(@$info['sponser_info']->f_name) . ' ' . esc(@$info['sponser_info']->l_name); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo display('email'); ?></td>
                                        <td><?php echo esc(@$info['sponser_info']->email); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo display('mobile'); ?></td>
                                        <td><?php echo esc(@$info['sponser_info']->phone); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /.row -->
<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display('personal_info'); ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo display('title'); ?></th>
                                <th><?php echo display('details'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo display('username'); ?></td>
                                <td><?php echo esc($info['my_info']->username); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo display('name'); ?></td>
                                <td><?php echo esc($info['my_info']->f_name) . ' ' . esc($info['my_info']->l_name); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo display('email'); ?></td>
                                <td><?php echo esc($info['my_info']->email); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo display('mobile'); ?></td>
                                <td><?php echo esc($info['my_info']->phone); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display('pending_withdraw'); ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo display('date'); ?></th>
                                <th><?php echo display('amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($pending_withdraw) {
                                foreach ($pending_withdraw as $key => $value) {
                            ?>

                            <tr>
                                <td><?php echo esc($value->request_date); ?></td>
                                <td>$<?php echo esc($value->amount); ?></td>
                            </tr>

                            <?php  }
                            } ?>
                        </tbody>
                    </table>
                    <a href="<?php echo base_url("customer/withdraw/withdraw_list") ?>">See all | Pending Withdraw</a>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display('personal_sales'); ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo display('name'); ?></th>
                                <th><?php echo display('mobile'); ?></th>
                                <th><?php echo display('status'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($my_sales) {
                                foreach ($my_sales as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo esc($value->f_name) . ' ' . esc($value->l_name); ?></td>
                                <td><?php echo esc($value->phone); ?></td>
                                <td><?php echo esc($value->status); ?></td>
                            </tr>
                            <?php  }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <a href="<?php echo base_url("customer/account/my_generation") ?>">See all | See Genealogy</a>
            </div>
        </div>

    </div>
</div>