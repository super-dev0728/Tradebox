<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>
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
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <?php echo form_open('customer/withdraw/store',array('name'=>'withdraw'));?>
                        <div class="border_preview">
                            <div class="form-group row">
                                <label for="amount" class="col-sm-4 col-form-label"><?php echo display('amount');?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="amount" type="number" min="10" max="5000" id="amount">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="withdraw_payment_method" class="col-sm-4 col-form-label"><?php echo display('payment_method');?></label>
                                <div class="col-sm-8">
                                    <select class="form-control basic-single" name="method" id="withdraw_payment_method">
                                        <option value="">-<?php echo display('payment_method')?>-</option>
                                        <?php foreach ($payment_gateway as $key => $value) {  ?>
                                        <option value="<?php echo esc($value->identity); ?>"><?php echo esc($value->agent); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="changed" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <span id="walletidis" class="text-success"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><?php echo display('otp_send_to')?></label>
                                <div class="col-sm-5">
                                    <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio1" value="1" name="varify_media" checked="">
                                        <label for="inlineRadio1"> <?php echo display('sms')?> </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="inlineRadio2" value="2" name="varify_media">
                                        <label for="inlineRadio2"> <?php echo display('email')?> </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="walletid" value="">

                            <div class="row m-b-15" align="center">
                                <div class="col-sm-12">
                                    <button type="submit" disabled class="btn btn-success w-md m-b-5"><?php echo display('withdraw');?></button>
                                    <a href="<?php echo base_url('customer/dashboard');?>" class="btn btn-danger w-md m-b-5"><?php echo display('cancel')?></a>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url("public/assets/js/main_custom.js?v=5.9") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("app/Modules/Finance/Assets/Customer/js/custom.js?v=1.1") ?>" type="text/javascript"></script>