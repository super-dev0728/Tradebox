<?php namespace App\Modules\Coinpayment\Controllers\Admin;


class Payment_gateway extends BaseController
{

	
	public function form()
	{ 
		$pagewhere=array('identity'=>'coinpayment');
		$data['payment_gateway']= $this->common_model->read('payment_gateway', $pagewhere);
		$data['title']  = display('edit_payment_gateway');


        $this->validation->setRule('public_key', display('public_key'),'required|max_length[1000]');
        $this->validation->setRule('private_key', display('private_key'),'required|max_length[1000]');
        $this->validation->setRule('mercent_id', display('mercent_id'), 'required|trim');
        $this->validation->setRule('ipn_secret', display('ipn_secret'), 'required|trim');
        $this->validation->setRule('debug_email', display('debug_email'),'required|trim');
        $this->validation->setRule('coinpayment_wtdraw', 'Withdraw','required|trim');
        $this->validation->setRule('status', display('status'),'required|max_length[10]');

        if ($this->request->getMethod() == 'post') {
    		
    		if ($this->validation->withRequest($this->request)->run()) 
    		{	
    			
                $public_key         = $this->request->getPost('public_key', FILTER_SANITIZE_STRING);
                $private_key        = $this->request->getPost('private_key', FILTER_SANITIZE_STRING);
                $mercent_id         = $this->request->getPost('mercent_id', FILTER_SANITIZE_STRING);
                $ipn_secret         = $this->request->getPost('ipn_secret', FILTER_SANITIZE_STRING);
                $debug_email        = $this->request->getPost('debug_email', FILTER_SANITIZE_STRING);
                $coinpayment_wtdraw = $this->request->getPost('coinpayment_wtdraw', FILTER_SANITIZE_STRING);
                
                if($this->request->getPost('debuging_active', FILTER_SANITIZE_STRING)){

                    $debuging_active = 1;

                } else {

                    $debuging_active = 0;
                }

                $post_data = array(

                    'marcent_id'        => $mercent_id,
                    'ipn_secret'        => $ipn_secret,
                    'debug_email'       => $debug_email,
                    'debuging_active'   => $debuging_active,
                    'withdraw'          => $coinpayment_wtdraw
                );

                $data_value = json_encode($post_data);

                $public_key_json = json_encode($public_key);
                $private_key_json = json_encode($private_key);


                $data['payment_gateway']   = (object)$userdata = array(

    	            'id'            => $this->request->getPost('id', FILTER_SANITIZE_STRING),
    	            'agent'         => $this->request->getPost('agent', FILTER_SANITIZE_STRING),
    	            'public_key'    => $public_key,
    	            'private_key'   => $private_key,
                    'data'          => $data_value,
    	            'status'        => $this->request->getPost('status', FILTER_SANITIZE_STRING)
    	        );

    			if ($this->common_model->update('payment_gateway',$userdata, array('id' =>  $this->request->getPost('id')))) {
    				$this->session->setFlashdata('message', display('update_successfully'));
    			} else {
    				$this->session->setFlashdata('exception', display('please_try_again'));
    			}
                return redirect()->to(base_url('backend/payment_gateway/coinpayment_setting'));

    		}  else {

                $this->session->setFlashdata("exception", $this->validation->listErrors());
                return redirect()->route('backend/payment_gateway/coinpayment_setting');
            }
        }

		
		$data['content'] = $this->BASE_VIEW . '\Payment_gateway\form';
        return $this->template->admin_layout($data);
	}


	
}