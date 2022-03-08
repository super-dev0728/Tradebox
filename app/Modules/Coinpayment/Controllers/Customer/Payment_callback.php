<?php namespace App\Modules\Coinpayment\Controllers\Customer;


class Payment_callback extends BaseController
{


	private function errorAndDie($error_msg,$cp_debug_email) {


			if (!empty($cp_debug_email)) { 
				$report = 'Error: '.$error_msg."\n\n"; 
				$report .= "getPost Data\n\n"; 
				foreach ($_POST as $k => $v) { 
					$report .= "|$k| = |$v|\n"; 
				} 
				mail($cp_debug_email, 'CoinPayments IPN Error', $report); 
			} 
			die('IPN Error: '.$error_msg);

		} 

		public function conipayment_confirm(){

			$gateway = $this->db->table('payment_gateway')->select('*')->where('identity', 'coinpayment')->where('status', 1)->get()->getRow();

			if (is_string($gateway->data) && is_array(json_decode($gateway->data, FILTER_SANITIZE_STRING)) && (json_last_error() == JSON_ERROR_NONE) ? true : false) {

				$data 			= json_decode(@$gateway->data, FILTER_SANITIZE_STRING);

				$cp_merchant_id = @$data['marcent_id'];
				$cp_ipn_secret 	= @$data['ipn_secret'];
				$debug_active	= @$data['debuging_active'];
				$debug_email 	= @$data['debug_email'];

			} else {

				$cp_merchant_id = "";
				$cp_ipn_secret 	= "";
				$debug_active	= "";
				$debug_email 	= "";
			}

			$order_currency	= $this->request->getPost("currency1");
			$amount1 		= number_format((float)($this->request->getPost("amount1")), 8, '.', '');
			$order_total 	= $amount1;

			$feesamount 	= !empty($this->request->getPost("custom"))?$this->request->getPost("custom"):0;
			$depositAmount	= $amount1-$feesamount;

			$reg = array(

				'amount1'			=>$this->request->getPost("amount1", FILTER_SANITIZE_STRING),
				'amount2'			=>$this->request->getPost("amount2", FILTER_SANITIZE_STRING),
				'buyer_name'		=>$this->request->getPost("buyer_name", FILTER_SANITIZE_STRING),
				'currency1'			=>$this->request->getPost("currency1", FILTER_SANITIZE_STRING),
				'currency2'			=>$this->request->getPost("currency2", FILTER_SANITIZE_STRING),
				'fee'				=>$this->request->getPost("fee", FILTER_SANITIZE_STRING),
				'ipn_id'			=>$this->request->getPost("ipn_id", FILTER_SANITIZE_STRING),
				'ipn_mode'			=>$this->request->getPost("ipn_mode", FILTER_SANITIZE_STRING),
				'ipn_type'			=>$this->request->getPost("ipn_type", FILTER_SANITIZE_STRING),
				'ipn_version'		=>$this->request->getPost("ipn_version", FILTER_SANITIZE_STRING),
				'merchant'			=>$this->request->getPost("merchant", FILTER_SANITIZE_STRING),
				'received_amount'	=>$this->request->getPost("received_amount", FILTER_SANITIZE_STRING),
				'received_confirms'	=>$this->request->getPost("received_confirms", FILTER_SANITIZE_STRING),
				'status'			=>$this->request->getPost("status", FILTER_SANITIZE_STRING),
				'status_text'		=>$this->request->getPost("status_text", FILTER_SANITIZE_STRING),
				'txn_id'			=>$this->request->getPost("txn_id", FILTER_SANITIZE_STRING)
			);

			$deposit_date 	= date('Y-m-d H:i:s');
			$wheredata 		= "txn_id='".$this->request->getPost("txn_id")."' AND user_id!=''";
			$instantdata	= $this->db->table("coinpayments_payments")->select("*")->where($wheredata)->get()->getRow();

			$dbt_deposit_data 		= array(

				'user_id'			=> @$instantdata->user_id,
				'currency_symbol'	=> @$this->request->getPost("currency2", FILTER_SANITIZE_STRING),
				'amount'         	=> @$this->request->getPost("amount2", FILTER_SANITIZE_STRING),
				'method_id'      	=> @$gateway->identity,
				'fees_amount'    	=> @$feesamount,
				'comment'        	=> @$this->request->getPost("txn_id", FILTER_SANITIZE_STRING),
				'status'         	=> 0,
				'deposit_date'   	=> @$deposit_date,
				'ip'             	=> @$this->request->getipAddress()

			);

			if (!$this->request->getPost("ipn_mode", FILTER_SANITIZE_STRING) || $this->request->getPost("ipn_mode", FILTER_SANITIZE_STRING)!= 'hmac') { 

				if($debug_active==1){
					$this->errorAndDie('IPN Mode is not HMAC',$debug_email);
				}
			}

			if (!$this->request->getServer("HTTP_HMAC") || empty($this->request->getServer("HTTP_HMAC"))) { 

				if($debug_active==1){
					$this->errorAndDie('No HMAC signature sent.',$debug_email);
				}
			} 

			$request = file_get_contents('php://input'); 
			if ($request === FALSE || empty($request)) {

				if($debug_active==1){
					$this->errorAndDie('Error reading getPost data',$debug_email);
				}
			} 

			if (!$this->request->getPost("merchant", FILTER_SANITIZE_STRING) || $this->request->getPost("merchant", FILTER_SANITIZE_STRING) != trim($cp_merchant_id)) {

				if($debug_active==1){
					$this->errorAndDie('No or incorrect Merchant ID passed',$debug_email);
				}
			} 

			$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
			if (!hash_equals($hmac, $this->request->getServer("HTTP_HMAC"))) { 

				if($debug_active==1){
					$this->errorAndDie('HMAC signature does not match',$debug_email);
				}
			}

			$txn_id 		= $this->request->getPost("txn_id", FILTER_SANITIZE_STRING); 
			$item_name 		= $this->request->getPost("item_name", FILTER_SANITIZE_STRING); 
			$item_number	= $this->request->getPost("item_number", FILTER_SANITIZE_STRING);
			$amount1 		= number_format((float)($this->request->getPost("amount1", FILTER_SANITIZE_STRING)),8, '.', '');
			$amount2 		= number_format((float)($this->request->getPost("amount2", FILTER_SANITIZE_STRING)),8, '.', '');
			$currency1 		= $this->request->getPost("currency1", FILTER_SANITIZE_STRING); 
			$currency2 		= $this->request->getPost("currency2", FILTER_SANITIZE_STRING); 
			$status 		= intval($this->request->getPost("status", FILTER_SANITIZE_STRING)); 
			$status_text 	= $this->request->getPost("status_text", FILTER_SANITIZE_STRING);

			if ($currency1 != $order_currency) {

				if($debug_active==1){
					$this->errorAndDie('Original currency mismatch!',$debug_email);
				}
			}

			if ($amount1 < $order_total) {

				if($debug_active==1){
					$this->errorAndDie('Amount is less than order total!',$debug_email);
				}
			} 

			if ($status >= 100 || $status == 2) {

				$dbt_deposit_check = $this->db->table("dbt_deposit")->select('*')->where("user_id",@$instantdata->user_id)->where("comment",$this->request->getPost("txn_id"))->where("status",1)->get()->getRow();
				
				if(!$dbt_deposit_check){

					$this->common_model->save('coinpayments_payments', $reg);
					
					$balance_add = array(

						'user_id'           => @$instantdata->user_id,
						'currency_symbol'   => @$this->request->getPost("currency2", FILTER_SANITIZE_STRING), 
						'amount'           	=> $depositAmount,
						'last_update' 		=> @$deposit_date,
					);

					$deposit_balance 	= $this->web_model->coinpayments_balanceAdd($balance_add);

					if ($deposit_balance) {
						
						$depositdata = array(

							'user_id'            => @$instantdata->user_id,
							'balance_id'         => @$deposit_balance,
							'currency_symbol'    => @$this->request->getPost("currency2", FILTER_SANITIZE_STRING),
							'transaction_type'   => 'DEPOSIT',
							'transaction_amount' => $depositAmount,
							'transaction_fees' 	 => $feesamount,
							'ip'                 => @$this->request->getipAddress(),
							'date'               => @$deposit_date
						);

						$this->common_model->save('dbt_balance_log', $depositdata);
					}

					$deposit_date 	= date('Y-m-d H:i:s');

					$confirmdeposit = array(

						'depositdate'		=> $deposit_date,
						'user_id'			=>@$instantdata->user_id,
						'comment'			=>@$txn_id,
						'currency_symbol'	=>@$currency2
					);
					//confirm deposite data update start
					$updatedata = array(
			            'deposit_date'  =>$confirmdeposit['depositdate'],
			            'approved_date' =>$confirmdeposit['depositdate'],
			            'status'        =>1
			        );

			        $wheredatacoin = array(
			            'user_id'           =>$confirmdeposit['user_id'],
			            'comment'           =>$confirmdeposit['comment'],
			            'currency_symbol'   =>$confirmdeposit['currency_symbol']
			        );
			        $this->common_model->update('dbt_deposit', $updatedata, $wheredatacoin);
			        //confirm deposite data update start

					$this->refferalbonus(@$this->request->getPost("amount2"),@$this->request->getPost("currency2"),@$instantdata->user_id);
				}
			}
			else if ($status < 0) {

				$this->common_model->save('coinpayments_payments', $reg);

				if($status==-1){
					$this->coinpayments_cancel();
				}

			} else {

				$this->common_model->save('coinpayments_payments', $reg);

				$dbt_deposit = $this->db->table("dbt_deposit")->select('*')->where("comment",$this->request->getPost("txn_id"))->get()->getRow();
				if(!$dbt_deposit){
					$this->common_model->save('dbt_deposit', $dbt_deposit_data);
				}
			}
		}

		private function refferalbonus($amount="",$currency_symbol="",$user_id="")
		{
			$reffereldata = $this->common_model->findById('dbt_user', array('user_id' => $user_id));

			if($reffereldata->referral_id){
				$refferId = $reffereldata->referral_id;
				$rcommission = $this->common_model->findById('earnings', array('user_id' => $refferId, 'Purchaser_id' => $user_id, 'earning_type' => 'REFERRAL'));
				if(empty($rcommission)){
					$commissioninfo = $this->db->table('dbt_affiliation')->select('*')->where('status',1)->get();
					//here now problem may be
					if(!empty($commissioninfo)){
						$commission = $commissioninfo->getRow();
						$camount    = 0;
						if($commission->type=="PERCENT"){
							$camount = number_format(($amount*$commission->commission)/100,8);
						}
						else{
							$camount = number_format($commission->commission,8);
						}
						$commissiondata = array(
							'user_id'       => $refferId,
							'Purchaser_id'  => $user_id,
							'earning_type'  => 'REFERRAL',
							'amount'        => $camount,
							'date'          => date('Y-m-d'),
						);
						$this->common_model->save('earnings',$commissiondata);

						$balanceId 		= "";
						$checkbalance 	= $this->common_model->findById('dbt_balance', array('user_id' => $refferId, 'currency_symbol' => $currency_symbol));
						if($checkbalance){

							$totalbalance= $checkbalance->balance+$camount;
							$balanceId 	 = $checkbalance->id;
							$balancedata = array(
								'balance'       =>$totalbalance,
								'last_update'   =>date('Y-m-d H:i:s'),
							);
							
							$this->common_model->update('dbt_balance', $balancedata, array('user_id' => $refferId, 'currency_symbol' => $currency_symbol));

						} else {

							$balancedata = array(
								'user_id'    		=>$refferId,
								'currency_symbol' 	=>$currency_symbol,
								'balance'    		=>$camount,
								'last_update'		=>date('Y-m-d H:i:s')
							);
							$balanceId = $this->common_model->save_return_id("dbt_balance",$balancedata);
						}

						$depositdata = array(
							'user_id'            => $refferId,
							'balance_id'         => $balanceId,
							'currency_symbol'    => $currency_symbol,
							'transaction_type'   => 'REFERRAL',
							'transaction_amount' => $camount,
							'transaction_fees'   => 0,
							'ip'                 => $this->request->getipAddress(),
							'date'               => date('Y-m-d H:i:s')
						);

						$this->common_model->save('dbt_balance_log', $depositdata);
					}
				}
			}
		}

		public function coinpayments_cancel(){

			$this->session->setFlashdata('exception', "Payment Canceled/Failed");
		}
	
}