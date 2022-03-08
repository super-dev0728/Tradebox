<div class="ballance-content mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-bg">
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('transection') ?></th>
                                <th><?php echo display('amount') ?></th>
                                <th><?php echo display('fees') ?></th>
                                <th><?php echo display('crypto_dollar_currency') ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php $i=1; foreach ($balance_log as $key => $value) { ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo esc($value->transaction_type) ?></td>
                                <td><?php echo esc($value->transaction_amount) ?></td>
                                <td><?php echo esc($value->transaction_fees) ?></td>
                                <td><div class="d-flex marks-ico">
                                        <div><img src="<?php echo $value->image?IMAGEPATH.$value->image:$value->url ?>" alt="<?php echo esc($value->currency_symbol) ?>"></div>
                                        <div class="ico-name">
                                            <font><?php echo esc($value->full_name) ?></font>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php $i++; } ?>

                    </table>
                    <?php echo htmlspecialchars_decode($pager); ?>
                </div>
            </div>
        </div>
    </div>
</div>