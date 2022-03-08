<link href="<?php echo base_url("public/assets/js/sweetalert/sweetalert.css") ?>" rel="stylesheet">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display('confirm_withdraw');?></h6>
                    </div>
                </div>
                <div class="panel-title">
                    <h4></h4>
                </div>
            </div>
            <?php 
                $data = json_decode($v->data);
            ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <div class="border_preview">
                        <?php   $att = array('name'=>'verify','id'=>'verify'); echo form_open('#',esc($att));
                            echo form_hidden('confirm_id',esc($v->id));
                         ?>
                            <div class="table-responsive">
                                 
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th><?php echo display('amount');?></th>
                                            <td>$<?php echo esc($data->amount);?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('payment_method');?></th>
                                            <td><?php echo esc($data->method);?></td>
                                        </tr>
                                       
                                         <tr>
                                            <th><?php echo display('enter_verify_code');?></th>
                                            <td><input class="form-control" type="text" name="code" id="code"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-right">
                                <button type="button" class="btn btn-success w-md m-b-5" id="confirm_withdraw_btn">Confirm</button>
                                <button type="button" class="btn btn-danger w-md m-b-5">Cancel</button>
                            </div>
                            <?php echo form_close();?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url("public/assets/js/sweetalert/sweetalert.min.js") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("public/assets/js/main_custom.js?v=5.9") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("app/Modules/Finance/Assets/Customer/js/custom.js?v=1.1") ?>" type="text/javascript"></script>