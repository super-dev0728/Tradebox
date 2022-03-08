<link href="<?php echo base_url('public/assets/js/sweetalert/sweetalert.css')?>" rel="stylesheet">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card mb-4 ">
            <div class="card-header">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('confirm_transfer')?></h4>
                </div>
            </div>

            <?php $data = json_decode($v->data); ?>

            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <div class="border_preview">
                            <div class="table-responsive">
                                <?php 
                                    $att = array('name'=>'verify','id'=>'verify');
                                    echo form_open('#',$att);
                                    echo form_hidden('id',esc($v->id));
                                ?>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th><?php echo display('receiver_name')?></th>
                                            <td><?php echo esc($u->f_name).' '. esc($u->l_name);?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('email');?></th>
                                            <td><?php echo esc($u->email);?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('user_id');?></th>
                                            <td><?php echo esc($u->user_id);?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('transfer_amount');?></th>
                                            <td>$<?php echo esc($data->amount);?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('enter_verify_code');?></th>
                                            <td><input class="form-control" type="text" name="code" id="code"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php echo form_close(); ?>
                            </div>
                            <div class="text-right">
                                <button type="button" id="transfer_confirm_btn" class="btn btn-success w-md m-b-5">Confirm</button>
                                <button type="button" class="btn btn-danger w-md m-b-5">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('public/assets/js/sweetalert/sweetalert.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url("public/assets/js/main_custom.js?v=5.9") ?>" type="text/javascript"></script>
<script src="<?php echo base_url("app/Modules/Finance/Assets/Customer/js/custom.js?v=1.1") ?>" type="text/javascript"></script>