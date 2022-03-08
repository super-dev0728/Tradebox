<div class="payment-process-content">
        <div class="container">
             <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="payment-process">
                    <h2><?php echo $title; ?></h2>
                       <?php if ($deposit->deposit_method=='token')  { ?>
                            <table class="table table-bordered">
                              <tr>
                                 <td>
                                    <strong><?php echo display('important');?></strong></br>
                                    <ul>
                                       <li>
                                          <?php echo display('send_only');?> <strong><?php echo $deposit->currency_symbol;?></strong>
                                          <?php echo display('deposit_address');?>. <?php echo display('sending_any_other_coin_or_token_to_this_address_may_result_in_the_loss_of_your_deposit');?>.
                                       </li>
                                    </ul>
                                    <br>
                                    <center>
                                       <div class="diposit-address mt-20">
                                          <div class="label">
                                             <?php echo esc($deposit->currency_symbol);?> <?php echo display('deposit_address');?>.
                                          </div>
                                          <div class="dip_address">
                                             <strong><input type="text" id="copyed" value="<?php echo esc(@$gateway->public_key) ?>" readonly="readonly"/></strong>
                                          </div>
                                          <div class="copy_address mt-20">
                                             <button  class="btn btn-primary" onclick="copyFunction()"><?php echo display('copy_address');?></button>
                                          </div>
                                          <?php if ($gateway->secret_key=='show') { ?>
                                          <div class="diposit-qrcode mt-20">
                                             <div class="qrcode">
                                                <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo @$gateway->public_key ?>&choe=UTF-8" />
                                             </div>
                                          </div>
                                          <?php } ?>
                                       </div>
                                       <h4><?php echo esc($deposit->deposit_amount+(float)@$deposit->fees) ?> <?php echo esc($deposit->currency_symbol);?></h4>
                                    </center>
                                    <div class="please-note mt-20">
                                       <div class="textnote">
                                          <?php echo esc(@$gateway->private_key) ?>
                                       </div>
                                    </div>
                                    <div class="please-note mt-20">
                                       <div class="label_note">
                                          <a class="btn btn-success w-md m-b-5 text-right" href="<?php echo $deposit_data['approval_url'] ?>"><?php echo display('payment_complete');?></a>
                                          <a class="btn btn-danger w-md m-b-5 text-right" href="<?php echo $deposit_data['cancel_url'] ?>"><?php echo display('cancel');?></a>
                                       </div>
                                    </div>
                                 </td>
                              </tr>
                           </table>
                        <?php }  ?>
                    </div>
            </div>
        </div>
    </div>
</div>
