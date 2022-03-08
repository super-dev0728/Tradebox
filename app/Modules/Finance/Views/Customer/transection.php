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

                <div class="table-responsive border-top">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th><?php echo display('type');?></th>
                                <th><?php echo display('amount');?></th>
                                <th><?php echo display('fees');?></th>
                                <th><?php echo display('total');?></th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <th><?php echo display('diposit')?></th>
                                <td>$<?php echo (@$deposit?esc(@$deposit):'0.00');?></td>
                                <td>$<?php echo (@$d_fees?esc(@$d_fees):'0.00');?></td>
                                <td>$<?php echo $m_diposit = @$deposit;?></td>
                            </tr>

                            <tr>
                                <th><?php echo display('reciver')?></th>
                                <td>$<?php echo (@$reciver?esc(@$reciver):'0.00');?></td>
                                <td>$<?php echo '0.00';?></td>
                                <td>$<?php echo (@$reciver?esc(@$reciver):'0.00');?></td>
                            </tr>

                            <tr>
                                <th><?php echo display('my_payout');?></th>
                                <td>$<?php echo (@$my_payout?esc(@$my_payout):'0.00');?></td>
                                <td>$<?php echo '0.00';?></td>
                                <td>$<?php echo (@$my_payout?esc(@$my_payout):'0.00');?></td>
                            </tr>

                            <tr>
                                <th><?php echo display('commission');?></th>
                                <td>$<?php echo (@$commission?esc(@$commission):'0.00');?></td>
                                <td>$<?php echo '0.00';?></td>
                                <td>$<?php echo (@$commission?esc(@$commission):'0.00');?></td>
                            </tr>

                            <tr>
                                <th>Bonus</th>
                                <td>$<?php echo (@$bonuss?esc(@$bonuss):'0.00');?></td>
                                <td>$<?php echo '0.00';?></td>
                                <td>$<?php echo (@$bonuss?esc(@$bonuss):'0.00');?></td>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-success text-center"><?php echo display('total');?> =</td>
                                <td>$<?php  $plus = @$m_diposit+@$reciver+@$my_payout+@$commission+@$bonuss;
                                echo (@$plus?esc(@$plus):'0.00');
                                ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>


                <div class="table-responsive border-top">

                    <table class="table table-bordered table-striped table-hover">

                        <thead>
                            <tr>
                                <th><?php echo display('type');?></th>
                                <th><?php echo display('amount');?></th>
                                <th><?php echo display('fees');?></th>
                                <th><?php echo display('total');?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><?php echo display('investment')?></th>
                                <td>$<?php echo (@$investment?esc(@$investment):'0.00');?></td>
                                <td>$<?php echo '0.00';?></td>
                                <td>$<?php echo (@$investment?esc(@$investment):'0.00');?></td>
                            </tr>

                            <tr>
                                <th><?php echo display('withdraw')?></th>
                                <td>$<?php echo (@$withdraw?esc(@$withdraw):'0.00');?></td>
                                <td>$<?php echo (@$w_fees?esc(@$w_fees):'0.00');?></td>

                                <td>$<?php echo $m_withdraw = @$withdraw+@$w_fees;?></td>
                            </tr>
                            <tr>
                                <th><?php echo display('transfer');?></th>
                                <td>$<?php echo (@$transfar?esc(@$transfar):'0.00');?></td>
                                <td>$<?php echo (@$t_fees?esc(@$t_fees):'0.00');?></td>
                                
                                <td>$<?php 
                                @$m_transfer = @$transfar-@$t_fees;
                                echo (@$m_transfer?esc(@$m_transfer):'0.00');
                                ?></td>
                            </tr>

                            <tr>
                                <td colspan="3" class="text-danger text-center">TOTAL = </td>
                                <td>$<?php $minus = @$investment+@$m_withdraw+@$m_transfer;
                                echo (@$minus?esc(@$minus):'0.00');
                                ?></td>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-success text-center"><?php echo display('your_total_balance_is');?> = $<?php echo @$plus-@$minus;?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

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
                                    <th><?php echo display('date');?></th>
                                    <th><?php echo display('transection_category');?></th>
                                    <th><?php echo display('balance');?></th>
                                    <th><?php echo display('comment');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($transection!=NULL){ 
                                    foreach ($transection as $key => $value) {  
                                        ?>
                                        <tr>
                                            <td><?php echo esc($value->transection_date_timestamp);?></td>
                                            <td><?php echo esc($value->transection_category);?></td>
                                            <td><?php echo esc($value->amount);?></td>
                                            <td><?php echo esc($value->comments);?></td>
                                        </tr>
                                    <?php } } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/jszip.min.js"></script>

<script src="<?php echo base_url()?>/public/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.colVis.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/data-bootstrap4.active.js"></script>