<?php namespace App\Modules\Gourl\Controllers\Customer;


class Payment_callback extends BaseController
{

	public function bitcoin_confirm($orderidp = null){
       
		// Bitcoin Tranction log
		$order_id 		= explode('_', $orderidp);
		//$payment_type 	= @$order_id['0'];
		$user_id 		= @$order_id['2'];
		$device 		= @$order_id['3'];
		$deposit      	= $this->db->table('crypto_payments')->select('*')->where('orderID', $orderidp)->get()->getRow();
		$payment_type = $this->session->get('payment_type');

		if ($payment_type == 'deposit' && $deposit) {
            
			$userinfo = $this->common_model->findById('dbt_user', array('user_id' => $this->session->get('user_id')));

			$this->refferalbonus($deposit->amount, $deposit->coinLabel, $userinfo->user_id);

			$set = $this->common_model->findById('sms_email_send_setup',array('method' => 'email'));
			$smsPermission = $this->common_model->findById('sms_email_send_setup',array('method' => 'sms'));
			$appSetting = $this->common_model->findById('setting', array());

            #----------------------------
		    #  email verify smtp
		    #----------------------------
			if(!empty($set) && $set->deposit == 1){

				$post = array(

                    'title'   => $appSetting->title,
                    'to'      => $this->session->get('email'),
                    'date'    => $deposit->txCheckDate,
                    'name'    => $userinfo->first_name." ".$userinfo->last_name,
                    'amount'  => $deposit->coinLabel." ".$deposit->amount,
                );
            
                $config_var = array( 

                    'template_name' => 'deposit_success',
                    'template_lang' => $this->template->langSet() == 'english'?'en':'fr',
                );

                $message    = $this->common_model->email_msg_generate($config_var, $post);
                $send_email = array(

                    'title'     => $appSetting->title,
                    'to'        => $this->session->get('email'),
                    'subject'   => $message['subject'],
                    'message'   => $message['message'],
                );
                $code_send = $this->common_model->send_email($send_email);
		
			}

			$notification3 = array(

				'user_id'              => $userinfo->user_id,
				'subject'              => display('diposit'),
				'notification_type'    => 'deposit',
				'details'              => $message['message'],
				'date'                 => date('Y-m-d h:i:s'),
				'status'               => '0'
			);
            $this->common_model->save('notifications',$notification3);


			if(!empty($smsPermission) && $smsPermission->deposit == 1){

				$template = array( 

					'date'    => $deposit->txCheckDate,
                    'amount'  => $deposit->coinLabel." ".$deposit->amount,
                    'name'    => $userinfo->first_name." ".$userinfo->last_name,
                );

                $config_var = array( 

                    'template_name' => 'deposit_success',
                    'template_lang' => $this->template->langSet() == 'english'?'en':'fr',
                );
                $message    = $this->common_model->sms_msg_generate($config_var, $template);

                $send_sms = array(
                    'to'       => $userinfo->phone,
                    'message'  => $message['message'],
                );
                
                if (@$userinfo->phone) {

                   $code_send = $this->sms_lib->send($send_sms);
                } else {

                    $this->session->setFlashdata('exception', display('there_is_no_phone_number'));
                }

			}



			$this->session->remove('payment_type');
			$this->session->remove('deposit');
			$this->session->setFlashdata('message', display('payment_successfully'));

			$this->session->setFlashdata('message', "Payment successful, please wait for blockchain confirmation.It will take time.");
			return redirect()->to(base_url('balances'));

		}elseif ($payment_type == 'buy') {

			# code...
		}elseif ($payment_type == 'sell') {
			# code...


		}else {
			# code...

		}

	}

	public function bitcoin_cancel(){


	}

	public function gourl_callback(){
		require FCPATH.'app/Modules/Gourl/Libraries/gourl/lib/cryptobox.callback.php';

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


	
}