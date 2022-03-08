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
                    
                <?php echo form_open_multipart("backend/payment_gateway/token_setting") ?>
                <?php echo form_hidden('id', esc($payment_gateway->id)) ?> 
                <?php 
                    $level1 = 'Wallet';
                    $level2 = 'Message';
                ?>
                <div class="form-group row">
                        <label for="agent" class="col-sm-3 font-weight-600"><?php echo display('gateway_name') ?></label>
                        <div class="col-sm-8">
                            <div class="col-sm-8">
                                <input name="agent" value="<?php echo esc($payment_gateway->agent) ?>" class="form-control" type="text" id="agent">
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
                    <label for="bank_name" class="col-md-3 font-weight-600"></label>
                    <div class="col-md-8">
                        <div class="col-md-8">
                            <a href="<?php echo base_url('backend'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display("update") ?></button>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
</div>
