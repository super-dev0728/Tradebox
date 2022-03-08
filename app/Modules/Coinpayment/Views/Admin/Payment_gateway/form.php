<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?esc($title):null) ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php echo form_open_multipart("backend/payment_gateway/coinpayment_setting") ?>
                <?php echo form_hidden('id', esc($payment_gateway->id)) ?> 
                <?php 

                    $level1 = display('public_key');
                    $level2 = display('private_key');

                   if (is_string($payment_gateway->data) && is_array(json_decode($payment_gateway->data, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {

                        $coinpaymentdata    = json_decode($payment_gateway->data, true);

                        $marcent_id         = $coinpaymentdata['marcent_id'];
                        $ipn_secret         = $coinpaymentdata['ipn_secret'];
                        $debug_email        = $coinpaymentdata['debug_email'];
                        $debuging_active    = $coinpaymentdata['debuging_active'];
                        $withdraw           = $coinpaymentdata['withdraw'];
                        
                        if($debuging_active==1){
                            $check = "checked='checked'";
                        }
                        else{
                            $check = "";
                        }

                    } else {

                        $marcent_id         = "";
                        $ipn_secret         = "";
                        $debug_email        = "";
                        $check    = "";

                    }
                ?>
                <div class="form-group row">
                    <label for="agent" class="col-sm-3 font-weight-600"><?php echo display('gateway_name') ?></label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-7">
                                <input name="agent" value="<?php echo esc($payment_gateway->agent) ?>" class="form-control" type="text" id="agent">
                            </div>
                            <div class="col-sm-5">
                                <a target="_blank" href='https://www.coinpayments.net/'>Create Account</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="public_key" class="col-sm-3 font-weight-600"><?php echo esc($level1); ?> <i class="text-danger">*</i></label>
                 <div class="col-sm-8">
                      <div class="col-sm-8">
                        <input name="public_key" value="<?php echo esc($payment_gateway->public_key) ?>" class="form-control" type="text" id="public_key">
                      </div>
                 </div>
                </div> 
                <div class="form-group row">

                    <label for="private_key" class="col-sm-3 font-weight-600"><?php echo esc($level2); ?> <i class="text-danger">*</i></label>
                    <div class="col-sm-8">
                        <div class="col-sm-8">
                        <input name="private_key" value="<?php echo esc($payment_gateway->private_key) ?>" class="form-control" type="text" id="private_key">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mercent_id" class="col-sm-3 font-weight-600">Your Merchant ID <i class="text-danger">*</i></label>
                    <div class="col-sm-8">
                       <div class="col-sm-8">
                        <input name="mercent_id" value="<?php echo esc($marcent_id);?>" class="form-control" type="text" id="mercent_id"/>
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label for="ipn_secret" class="col-sm-3 font-weight-600">IPN Secret <i class="text-danger">*</i></label>
                    <div class="col-sm-8">
                         <div class="col-sm-8">
                        <input name="ipn_secret" value="<?php echo esc($ipn_secret);?>" class="form-control" type="text" id="ipn_secret">
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="debug_email" class="col-sm-3 font-weight-600">Debug Email <i class="text-danger">*</i></label>
                    <div class="col-sm-8">
                         <div class="col-sm-8">
                        <input name="debug_email" value="<?php echo esc($debug_email);?>" class="form-control" type="text" id="debug_email">
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="debuging_active" class="col-sm-3 font-weight-600">Debuging Active </label>
                    <div class="col-sm-8">
                        <div class="col-sm-6">
                        <input name="debuging_active" type="checkbox" id="debuging_active" <?php echo $check;?> > <?php echo display('active') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="debuging_active" class="col-sm-3 font-weight-600">Withdraw </label>
                    <div class="col-sm-8">
                        <div class="col-sm-6 pt10">
                        <label class="radio-inline">
                            <?php echo form_radio('coinpayment_wtdraw', '1', (($withdraw=='1' || $withdraw==null)?true:false)); ?>Automatic
                         </label>
                        <label class="radio-inline">
                            <?php echo form_radio('coinpayment_wtdraw', '0', (($withdraw=="0")?true:false) ); ?>Manual
                         </label>
                     </div>
                    </div>
                </div>
                <div class="form-group row">
                        <label for="status" class="col-sm-3 font-weight-600"><?php echo display('status') ?></label>
                        <div class="col-sm-6">
                            <div class="col-sm-6 pt10">
                            <label class="radio-inline">
                                <?php echo form_radio('status', '1', (($payment_gateway->status==1 || $payment_gateway->status==null)?true:false)); ?><?php echo display('active') ?>
                             </label>
                            <label class="radio-inline">
                                <?php echo form_radio('status', '0', (($payment_gateway->status=="0")?true:false) ); ?><?php echo display('inactive') ?>
                             </label> 
                        </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-3 font-weight-600"></label>
                        <div class="col-sm-9">
                            <a href="<?php echo base_url('backend'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo $payment_gateway->id?display("update"):display("create") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url("app/Modules/Gourl/Assets/Admin/js/custom.js?v=1.1") ?>" type="text/javascript"></script>