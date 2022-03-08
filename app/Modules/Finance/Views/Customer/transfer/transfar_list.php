<?php
$this->session = \Config\Services::session();
?>
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
                <div class="border_preview">
                    <div class="table-responsive">
                        <table id="example" class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%"><?php echo display('serial');?></th>
                                    <th><?php echo display('name');?></th>
                                    <th><?php echo display('type');?></th>
                                    <th><?php echo display('amount');?></th>
                                    <th><?php echo display('date');?></th>
                                    <th><?php echo display('mobile');?></th>
                                    <th><?php echo display('action');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($transfer!=NULL){
                                    $i=1;
                                    $user_id = $this->session->userdata('user_id');
                                    foreach ($transfer as $key => $value) {  

                                ?>
                                <tr>
                                    <td><?php echo esc($i++); ?></td>
                                    <td><?php echo esc($value->f_name).' '.esc($value->l_name); ?></td>
                                    <td><?php echo ($value->receiver_user_id==$user_id?'<b class="text-success">'.display('receive').'</b>':'<b class="text-danger">'.display('send').'</b>');?></td>
                                    <td><?php echo esc($value->amount); ?></td>
                                    <td><?php echo esc($value->date); ?></td>
                                    <td><?php echo esc($value->phone); ?></td>
                                    <td>
                                        <a class="btn btn-success" href="<?php echo base_url()?>/customer/transfer/<?php echo ($value->receiver_user_id==$user_id?'receive_details':'send_details');?>/<?php echo esc($value->transfer_id);?>"><?php echo display('details')?></a>
                                    </td>
                                </tr>
                                <?php } } ?>

                            </tbody>
                        </table>
                        <?php echo htmlspecialchars_decode($pager); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>