<div class="payment-process-content">
       <div class="container">
          <div class="row">
             <div class="col-lg-8 offset-lg-2">
                <div class="payment-process">
                    <h2><?php echo $title; ?></h2>
                        <?php if ($deposit->deposit_method=='stripe')  { ?>
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
                                        <td class="text-right">$<?php echo esc($deposit->deposit_amount+(float)@$deposit->fees) ?></td>
                                    </tr>
                                </table>
                                <button type="button" id="checkout-button" class="stripe-button-el btn btn-primary"><span>Pay with
                                                        Card</span></button>
                                
                                <input type='hidden' name='key' value="<?php echo esc($publishable_key); ?>" id="key">
                                <input type='hidden' name='description' value="<?php echo esc($deposit_data['description']) ?>" id="description">

                                <input type='hidden' name='sessionId' value="<?php echo esc($deposit_data['id']) ?>" id="sessionId">

                            <?php } ?>
                    </div>
            </div>
        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script src="<?php echo base_url("app/Modules/Stripe/Assets/Customer/js/custom.js") ?>" type="text/javascript"></script>