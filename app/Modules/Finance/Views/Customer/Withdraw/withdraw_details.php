<?php
$this->db =    db_connect();
    $builder = $this->db->table('setting');
    $settings = $builder->select("*")
                        ->get()
                        ->getRow();
    $this->uri = service('uri','<?php echo base_url(); ?>');

?>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
            <div class="card-body"  id="printableArea">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="<?php echo base_url(!empty($settings->logo)?esc($settings->logo):"assets/images/icons/logo.png"); ?>" class="img-responsive" alt="">
                        <br>
                        <address>
                            <strong><?php echo esc($settings->title) ?></strong><br>
                            <?php echo htmlspecialchars_decode($settings->description); ?><br>                            
                        </address>
                        
                    </div>
                    <div class="col-sm-6 text-right">
                        <h1 class="m-t-0">Withdraw No : <?php echo $this->uri->getsegment(4)?></h1>
                        <div><?php echo esc($withdraw->request_date);?></div>
                        <address>
                            <strong><?php echo esc($my_info->f_name).' '.esc($my_info->l_name);?></strong><br>
                            <?php echo esc($my_info->email);?><br>
                            <?php echo esc($my_info->phone);?><br>
                        </address>
                    </div>
                </div> <hr>
                <div class="table-responsive m-b-20">
                    <table class="table table-border table-bordered ">
                        <thead>
                            <tr>
                                <th><?php echo display('payment_method')?></th>
                                <th><?php echo display('wallet_id')?></th>
                                <th><?php echo display('amount')?></th>
                                <th><?php echo display('status')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div><strong><?php echo esc($withdraw->method);?></strong></div>
                                <td><?php echo esc($withdraw->walletid);?></td>
                                <td>$<?php echo esc($withdraw->amount);?></td>
                                <td>
                                    <?php 
                                        if($withdraw->status==1){
                                            echo ('<b class="text-warning">Pending</b>');
                                        }else if($withdraw->status==2){
                                            echo ('<b class="text-success">Success</b>');
                                        }else{
                                            echo ('<b class="text-danger">Cancel</b>');
                                        }
                                        ?>
                                </td>
                            </tr>
                           
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel-footer text-right">
               <button type="button" class="btn btn-info print"><span class="fa fa-print"></span></button>
            </div>
        </div>
    </div>
</div>

        