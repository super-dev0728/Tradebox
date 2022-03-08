<?php
    $this->db =    db_connect();
    $builder = $this->db->table('setting');
    $settings = $builder->select("*")
                        ->get()
                        ->getRow();
    $this->uri = service('uri','<?php echo base_url(); ?>');
    $data = json_decode($v->data);
    
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-4">
            <div class="card-body"  id="printableArea">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="<?php echo base_url(!empty($settings->logo)?$settings->logo:"assets/images/icons/logo.png"); ?>" class="img-responsive" alt="">
                        <br>
                        <address>
                            <strong><?php echo esc($settings->title) ?></strong><br>
                            <?php echo htmlspecialchars_decode($settings->description); ?><br>
                            
                        </address>
                        
                    </div>
                    <div class="col-sm-6 text-right">
                        <h1 class="m-t-0">Transfer No : <?php echo $this->uri->getsegment(4)?></h1>
                        <div><?php echo date('d-M-Y');?></div>
                        <address>
                            <strong><?php echo esc($my_info->f_name).' '.esc($my_info->l_name); ?></strong><br>
                            <?php echo esc($my_info->email);?><br>
                            <?php echo esc($my_info->phone);?><br>
                            <abbr title="Phone">Account :</abbr> <?php echo esc($my_info->user_id); ?>
                        </address>
                    </div>
                </div> <hr>
                <div class="table-responsive m-b-20">
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
                                <td><?php echo esc($data->amount);?></td>
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