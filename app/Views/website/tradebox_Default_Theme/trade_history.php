    <div class="ballance-content mt-4 container">
        <div class="row">
                <div class="content-title">
                    <h4><?php echo display('trade_history') ?></h4>
                </div>
                <div class="history-table tableFixHead">
                    <table class="table table-responsive">
                        <thead>
                            <tr class="table-bg">
                                <th title="<?php echo display('trade') ?>"><?php echo display('trade') ?></th>
                                <th title="<?php echo display('rate') ?>"><?php echo display('rate') ?></th>
                                <th class="text-right" title="<?php echo display('required_qty') ?>">Req.Qty</th>
                                <th class="text-right" title="<?php echo display('available_qty') ?>">Av.Qty</th>
                                <th class="text-right" title="<?php echo display('required_amount') ?>">Req.Amt</th>
                                <th class="text-right" title="<?php echo display('available_amount') ?>">Av.Amt</th>
                                <th title="<?php echo display('market') ?>"><?php echo display('market') ?></th>
                                <th title="<?php echo display('open') ?>"><?php echo display('open') ?></th>
                                <th title="<?php echo display('complete_qty') ?>">C.Qty</th>
                                <th class="text-right" title="<?php echo display('complete_amount') ?>">C.Amt</th>
                                <th title="<?php echo display('trade_time') ?>"><?php echo display('trade_time') ?></th>
                                <th title="<?php echo display('status') ?>"><?php echo display('status') ?></th>
                            </tr>
                        </thead>
                        <tbody id="usertradeHistory">
                            <?php  foreach ($user_trade_history as $key => $value) { ?>
                            	<tr>
                            		<td><?php echo esc($value->bid_type) ?></td>
                            		<td class="text-right"><?php echo esc(number_format($value->bid_price,6)) ?></td>
                                    <td class="text-right"><?php echo esc(number_format($value->bid_qty,6)) ?></td>
                            		<td class="text-right"><?php echo esc(number_format($value->bid_qty_available,6)) ?></td>
                            		<td class="text-right"><?php echo esc(number_format($value->total_amount,6)) ?></td>
                                    <td class="text-right"><?php echo esc(number_format($value->amount_available,6)) ?></td>
                                    <td><?php echo esc($value->market_symbol) ?></td>
                                    <td><?php echo esc($value->open_order) ?></td>
                                    <td class="text-right"><?php echo esc(number_format($value->complete_qty?$value->complete_qty:0,6)) ?></td>
                                    <td class="text-right"><?php echo esc(number_format($value->complete_amount?$value->complete_amount:0,6)) ?></td>
                                    <td><?php echo esc($value->success_time?$value->success_time:$value->open_order) ?></td>
                            		<td class="text-center"><?php echo esc($value->status) == 0 ? "<i title='Canceled' class='far fa-times-circle'></i>" : (esc($value->status) == 1 ? "<i title='Complete' class='fas fa-check-circle'></i>" : '<div class="progress"><div title="Running" class="progress-bar progress-bar-striped width100percent">Running</div></div>') ?></td>
                            	</tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- End of Trade History -->
        </div>
    </div>