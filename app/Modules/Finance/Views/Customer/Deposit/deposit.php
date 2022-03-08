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
                        <div class="border_preview">
                            <?php echo form_open(site_url('customer/deposit/payment_gateway'),array('name'=>'deposit_form','id'=>'deposit_form'));?>
                            <div class="form-group row">
                                <label for="deposit_amount" class="col-sm-4 col-form-label"><?php echo display('deposit_amount');?></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="amount" required type="text" id="deposit_amount" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="deposit_payment_method" class="col-sm-4 col-form-label"><?php echo display('deposit_method');?></label>
                                <div class="col-sm-8">
                                    <select class="form-control basic-single" name="method" required id="deposit_payment_method" disabled>
                                        <option value=""><?php echo display('deposit_method');?></option>
                                        <?php foreach ($payment_gateway as $key => $value) {  ?>
                                        <option value="<?php echo esc($value->identity); ?>"><?php echo esc($value->agent); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="changed" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <span id="fee" class="text-success"></span>
                                </div>
                            </div>

                            <span class="payment_info">
                            <div class="form-group row">
                                <label for="comments" class="col-sm-4 col-form-label"><?php echo display('comments');?></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="comments" id="comments" rows="3"></textarea>
                                </div>
                            </div>
                            </span>

                            <div class="row m-b-15" align="center">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('diposit');?></button>
                                    <a href="<?php echo base_url('customer/dashboard');?>" class="btn btn-danger w-md m-b-5"><?php echo display('cancel')?></a>
                                </div>
                            </div>

                            <input type="hidden" name="level" value="deposit">
                            <input type="hidden" name="fees" value="">

                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /.row -->
<script src="<?php echo base_url("public/assets/js/main_custom.js?v=5.9") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("app/Modules/Finance/Assets/Customer/js/custom.js?v=1") ?>" type="text/javascript"></script>
