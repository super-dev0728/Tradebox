<div class="payment-process-content">
    <div class="container">
         <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="payment-process">
                    <?php if ($deposit->deposit_method=='coinpayment') { ?>

                            <table class="table table-bordered">
                              <tr>
                                 <td>
                                    <strong>Important</strong></br>
                                    <ul>
                                       <li>
                                          Send Only <strong><?php echo esc($deposit->currency_symbol);?></strong>
                                          deposit address. Sending any other coin or token to this address may result in the loss of your deposit.
                                       </li>
                                    </ul>
                                    <br>
                                    <center>
                                       <div class="diposit-address mt-20">
                                          <div class="label">
                                             <?php echo esc($deposit->currency_symbol);?> Diposit Address.
                                          </div>
                                          <div class="dip_address">
                                             <strong><input type="text" id="copyed" value="<?php echo esc($deposit_data['result']['address'])?>" readonly="readonly"/></strong>
                                          </div>
                                          <div class="copy_address mt-20">
                                             <button  class="btn btn-primary" onclick="copyFunction()">Copy Address</button>
                                          </div>
                                          <div class="diposit-qrcode mt-20">
                                             <div class="qrcode">
                                                <img src="<?php echo $deposit_data['result']['qrcode_url'] ?>" />
                                             </div>
                                          </div>
                                          <div class="deposit-balance mt-20">
                                             <h2><?php echo esc(number_format($deposit->deposit_amount+(float)@$deposit->fees,8))." <span>".esc($deposit->currency_symbol); ?></span></h2>
                                          </div>
                                       </div>
                                    </center>
                                    <div class="please-note mt-20">
                                       <div class="label_note">
                                          Please Note
                                       </div>
                                       <div class="textnote">
                                          <ul>
                                             <li>Coins will be deposited immediately after <font color="#03a9f4"><?php echo esc($deposit_data['result']['confirms_needed']);?></font> network confirmations</li>
                                             <li>You can track its progress on the <a target="_blank" href="<?php echo $deposit_data['result']['status_url'];?>"><?php echo display('history');?></a>  <?php echo display('page');?></li>
                                          </ul>
                                       </div>
                                    </div>
                                    <div class="please-note mt-20">
                                       <div class="label_note">
                                          <a href="<?php echo base_url()?>"><button type="button" class="btn btn-success"><?php echo display('back');?></button></a>
                                       </div>
                                    </div>
                                 </td>
                              </tr>
                           </table>

                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>