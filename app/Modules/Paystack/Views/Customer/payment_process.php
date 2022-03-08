<div class="payment-process-content">
    <div class="container">
         <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="payment-process">
                    <h2><?php echo $title; ?></h2>
                    <?php if ($deposit->deposit_method=='paystack')  { ?>
                        <table class="table table-bordered">
                            <tr>
                                <th><?php echo display("user_id") ?></th>
                                <td class="text-right"><?php echo esc($deposit->user_id) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("payment_gateway") ?></th>
                                <td class="text-right"><?php echo esc($deposit->deposit_method) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("amount") ?></th>
                                <td class="text-right">$<?php echo esc($deposit->deposit_amount) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("fees") ?></th>
                                <td class="text-right">$<?php echo esc($deposit->fees) ?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td class="text-right">$<?php echo esc($deposit->deposit_amount+$deposit->fees) ?></td>
                            </tr>
                        </table>
                        <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data ?>">Payment Process</a>
                        <a href="<?php echo base_url('deposit'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>                               
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
