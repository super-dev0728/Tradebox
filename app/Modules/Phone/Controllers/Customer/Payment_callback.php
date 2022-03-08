<?php 
namespace App\Modules\Phone\Controllers\Customer;


class Payment_callback extends BaseController
{
	public function phone_confirm(){

		$payment_type = $this->session->get('payment_type');

		if ($payment_type == 'deposit') {
			
			$payment_type 	= $this->session->get('payment_type');
			$deposit 	= $this->session->get('deposit');
			$userdata = array(

				'user_id'       => $deposit->user_id,
				'amount'    	=> $deposit->deposit_amount,
				'method_id'     => $deposit->deposit_method,
				'fees_amount'   => $deposit->fees,
				'currency_symbol' => $deposit->currency_symbol,
				'comment'       => $deposit->comment,
				'deposit_date'	=> $deposit->deposit_date,
				'status'    	=> 0,
			);   	

	    	//Store Data On Deposit
			if ($this->payment_model->paymentStore($userdata)) {

				$this->session->remove('deposit');
				$this->session->remove('payment_type');
				$this->session->setFlashdata('message', "Wait for Confirmation");
                return redirect()->to(base_url('balances'));

			} else {
				$this->session->remove('deposit');
				$this->session->remove('payment_type');
				$this->session->setFlashdata('exception', display('please_try_again'));
                return redirect()->to(base_url('deposit'));
			}

		}elseif ($payment_type == 'buy') {
			# code...


		}elseif ($payment_type == 'sell') {
			# code...

		}else {
			# code...

		}

		$this->session->unset_userdata($payment_type);
		$this->session->set_flashdata('message', display('payment_successfully'));
		return redirect()->to(base_url('customer/deposit/show_list'));

	}

	public function phone_cancel(){

		$this->session->set_flashdata('exception', "Payment Canceled/Faild");
		return redirect()->to(base_url('deposit'));
	}
}