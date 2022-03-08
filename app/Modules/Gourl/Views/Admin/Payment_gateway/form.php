<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 col-form-label mb-0"><?php echo (!empty($title)?esc($title):null) ?></h6>
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
                
                    <div class="form-group row">
                        <div class="col-form-label col-sm-3">
                            <label class="col-form-label ">Callback Url</label>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="copyed1" value="<?php echo base_url('customer/payment_callback/gourl_callback'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary copy1 p-2" type="button">Copy</button>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php echo form_open_multipart("backend/payment_gateway/gourl_setting") ?>
                <?php echo form_hidden('id', esc($payment_gateway->id)) ?> 
                <?php 
                    $level1 = display('public_key');
                    $level2 = display('private_key');
                    $public_key = unserialize($payment_gateway->public_key);
                    $private_key = unserialize($payment_gateway->private_key);
                    $i=0;
                    foreach ($public_key as $key => $value) { 
                        $pb_key[$i] = $key;
                        $pb_val[$i] = $value;

                        $i++;

                    }
                    $j=0;
                    foreach ($private_key as $key => $value) { 
                        $piv_key[$j] = $key;
                        $piv_val[$j] = $value;

                        $j++;
                    }
                ?>
                <div class="form-group row">
                        <label for="agent" class="col-sm-3 col-form-label"><?php echo display('gateway_name') ?></label>
                        <div class="col-sm-6">
                            <input name="agent" value="<?php echo esc($payment_gateway->agent) ?>" class="form-control" type="text" id="agent">
                        </div>
                        <div class='col-sm-3'>
                           <a href='https://gourl.io/view/registration' target='_blank'>Create Account</a>
                        </div>
                </div>
               <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bitcoin</label>
                    <input name="key1" value="bitcoin" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key" value="<?php echo esc(@$pb_val[0]) ?>" class="form-control col-sm-12" type="text" id="public_key" placeholder="<?php echo esc($level1); ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key" value="<?php echo esc(@$piv_val[0]) ?>" class="form-control col-sm-12" type="text" id="private_key" placeholder="<?php echo $level2; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bitcoincash</label>
                    <input name="key2" value="bitcoincash" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key2" value="<?php echo esc(@$pb_val[1]) ?>" class="form-control col-sm-12" type="text" id="public_key2" placeholder="<?php echo esc($level1); ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key2" value="<?php echo esc(@$piv_val[1]) ?>" class="form-control col-sm-12" type="text" id="private_key2" placeholder="<?php echo esc($level2); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Litecoin</label>
                    <input name="key3" value="litecoin" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key3" value="<?php echo esc(@$pb_val[2]) ?>" class="form-control col-sm-12" type="text" id="public_key3" placeholder="<?php echo $level1; ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key3" value="<?php echo @$piv_val[2] ?>" class="form-control col-sm-12" type="text" id="private_key3" placeholder="<?php echo esc($level2); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Dash</label>
                    <input name="key4" value="dash" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key4" value="<?php echo esc(@$pb_val[3]) ?>" class="form-control col-sm-12" type="text" id="public_key4" placeholder="<?php echo esc($level1); ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key4" value="<?php echo esc(@$piv_val[3]) ?>" class="form-control col-sm-12" type="text" id="private_key4" placeholder="<?php echo esc($level2); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Dogecoin</label>
                    <input name="key5" value="dogecoin" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key5" value="<?php echo esc(@$pb_val[4]) ?>" class="form-control col-sm-12" type="text" id="public_key5" placeholder="<?php echo $level1; ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key5" value="<?php echo esc(@$piv_val[4]) ?>" class="form-control col-sm-12" type="text" id="private_key5" placeholder="<?php echo esc($level2); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Speedcoin</label>
                    <input name="key6" value="speedcoin" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key6" value="<?php echo esc(@$pb_val[5]) ?>" class="form-control col-sm-12" type="text" id="public_key6" placeholder="<?php echo $level1; ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key6" value="<?php echo esc(@$piv_val[5]) ?>" class="form-control col-sm-12" type="text" id="private_key6" placeholder="<?php echo $level2; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Reddcoin</label>
                    <input name="key7" value="reddcoin" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key7" value="<?php echo esc(@$pb_val[6]) ?>" class="form-control col-sm-12" type="text" id="public_key7" placeholder="<?php echo $level1; ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key7" value="<?php echo esc(@$piv_val[6]) ?>" class="form-control col-sm-12" type="text" id="private_key7" placeholder="<?php echo $level2; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Potcoin</label>
                    <input name="key8" value="potcoin" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key8" value="<?php echo esc(@$pb_val[7]) ?>" class="form-control col-sm-12" type="text" id="public_key8" placeholder="<?php echo $level1; ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key8" value="<?php echo esc(@$piv_val[7]) ?>" class="form-control col-sm-12" type="text" id="private_key8" placeholder="<?php echo esc($level2); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Feathercoin</label>
                    <input name="key9" value="feathercoin" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key9" value="<?php echo esc(@$pb_val[8]) ?>" class="form-control col-sm-12" type="text" id="public_key9" placeholder="<?php echo esc($level1); ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key9" value="<?php echo esc(@$piv_val[8]) ?>" class="form-control col-sm-12" type="text" id="private_key9" placeholder="<?php echo esc($level2); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Vertcoin</label>
                    <input name="key10" value="vertcoin" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key10" value="<?php echo esc(@$pb_val[9]) ?>" class="form-control col-sm-12" type="text" id="public_key10" placeholder="<?php echo $level1; ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key10" value="<?php echo esc(@$piv_val[9]) ?>" class="form-control col-sm-12" type="text" id="private_key10" placeholder="<?php echo esc($level2); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Peercoin</label>
                    <input name="key11" value="peercoin" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key11" value="<?php echo esc(@$pb_val[10]) ?>" class="form-control col-sm-12" type="text" id="public_key11" placeholder="<?php echo esc($level1); ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key11" value="<?php echo esc(@$piv_val[10]) ?>" class="form-control col-sm-12" type="text" id="private_key11" placeholder="<?php echo esc($level2); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Monetaryunit</label>
                    <input name="key12" value="monetaryunit" type="hidden"/>
                    <div class="col-sm-8">                            
                        <div class="col-sm-6">
                            <input name="public_key12" value="<?php echo esc(@$pb_val[11]) ?>" class="form-control col-sm-12" type="text" id="public_key12" placeholder="<?php echo $level1; ?>">
                        </div>                            
                        <div class="col-sm-6 pt-1">
                            <input name="private_key12" value="<?php echo esc(@$piv_val[11]) ?>" class="form-control col-sm-12" type="text" id="private_key12" placeholder="<?php echo esc($level2); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Universalcurrency</label>
                    <input name="key13" value="universalcurrency" type="hidden"/>
                    <div class="col-sm-8">                            
                      <div class="col-sm-6">
                            <input name="public_key13" value="<?php echo esc(@$pb_val[12]) ?>" class="form-control col-sm-12" type="text" id="public_key13" placeholder="<?php echo esc($level1); ?>">
                        </div>                            
                       <div class="col-sm-6 pt-1">
                            <input name="private_key13" value="<?php echo esc(@$piv_val[12]) ?>" class="form-control col-sm-12" type="text" id="private_key13" placeholder="<?php echo esc($level2); ?>">
                        
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                        <label for="status" class="col-sm-3 col-form-label"><?php echo display('status') ?></label>
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
                        <label for="status" class="col-sm-3 col-form-label"></label>
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