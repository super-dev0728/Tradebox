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
                    
                <?php echo form_open_multipart("backend/payment_gateway/bank_setting") ?>
                <?php echo form_hidden('id', esc($payment_gateway->id)) ?> 
                <?php 
                    $json_decode_bank = json_decode($payment_gateway->public_key, true);

                    $acc_name       = @$json_decode_bank['acc_name'];
                    $acc_no         = @$json_decode_bank['acc_no'];
                    $branch_name    = @$json_decode_bank['branch_name'];
                    $swift_code     = @$json_decode_bank['swift_code'];
                    $abn_no         = @$json_decode_bank['abn_no'];
                    $country        = @$json_decode_bank['country'];
                    $bank_name      = @$json_decode_bank['bank_name'];
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
                    <label for="acc_name" class="col-md-3 font-weight-600">Account Name<i class="text-danger">*</i></label>
                    <div class="col-md-8">
                        <div class="col-sm-8">
                        <input name="acc_name" type="text" class="form-control" id="acc_name" value="<?php echo esc($acc_name); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="acc_no" class="col-md-3 font-weight-600">Account No<i class="text-danger">*</i></label>
                    <div class="col-md-8">
                         <div class="col-sm-8">
                        <input name="acc_no" type="text" class="form-control" id="acc_no" value="<?php echo esc($acc_no); ?>" required>
                         </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="branch_name" class="col-md-3 font-weight-600">Branch Name<i class="text-danger">*</i></label>
                    <div class="col-md-8">
                        <div class="col-sm-8">
                        <input name="branch_name" type="text" class="form-control" id="branch_name" value="<?php echo esc($branch_name); ?>" required>
                       </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="swift_code" class="col-md-3 font-weight-600">SWIFT Code</label>
                    <div class="col-md-8">
                        <div class="col-sm-8">
                        <input name="swift_code" type="text" class="form-control" id="swift_code" value="<?php echo esc($swift_code); ?>" >
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="abn_no" class="col-md-3 font-weight-600">ABN No</label>
                    <div class="col-md-8">
                        <div class="col-sm-8">
                        <input name="abn_no" type="text" class="form-control" id="abn_no" value="<?php echo esc($abn_no); ?>" >
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="country" class="col-md-3 font-weight-600">Country<i class="text-danger">*</i></label>
                    <div class="col-md-8">
                        <div class="col-sm-8">
                        <select class="form-control basic-single" name="country" id="country">
                            <option>Select Option</option>
                            <?php foreach ($countrys as $key => $value) { ?>
                                <option value="<?php echo $value->iso ?>" <?php echo $value->iso==$country?'selected':null ?> ><?php echo esc($value->nicename) ?></option>
                            <?php } ?>                                            
                        </select>
                       </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bank_name" class="col-md-3 font-weight-600">Bank Name<i class="text-danger">*</i></label>
                    <div class="col-md-8">
                        <div class="col-sm-8">
                        <input name="bank_name" type="text" class="form-control" id="bank_name" value="<?php echo esc($bank_name); ?>" required>
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
