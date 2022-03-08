<?php namespace App\Modules\Gourl\Controllers\Admin;


class Payment_gateway extends BaseController
{

	
	public function form()
	{ 
		$pagewhere=array('identity'=>'bitcoin');
		$data['payment_gateway']= $this->common_model->read('payment_gateway', $pagewhere);
		
		$data['title']  = display('edit_payment_gateway');

        $this->validation->setRule('status', display('status'),'required|max_length[10]');
        
        if ($this->request->getMethod() == 'post') {
		
    		if ($this->validation->withRequest($this->request)->run()) 
    		{	
    			
                
                $public_key = serialize(array(

                    $this->request->getPost('key1', FILTER_SANITIZE_STRING)  => $this->request->getPost('public_key', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key2', FILTER_SANITIZE_STRING)  => $this->request->getPost('public_key2', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key3', FILTER_SANITIZE_STRING)  => $this->request->getPost('public_key3', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key4', FILTER_SANITIZE_STRING)  => $this->request->getPost('public_key4', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key5', FILTER_SANITIZE_STRING)  => $this->request->getPost('public_key5', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key6', FILTER_SANITIZE_STRING)  => $this->request->getPost('public_key6', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key7', FILTER_SANITIZE_STRING)  => $this->request->getPost('public_key7', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key8', FILTER_SANITIZE_STRING)  => $this->request->getPost('public_key8', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key9', FILTER_SANITIZE_STRING)  => $this->request->getPost('public_key9', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key10', FILTER_SANITIZE_STRING) => $this->request->getPost('public_key10', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key11', FILTER_SANITIZE_STRING) => $this->request->getPost('public_key11', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key12', FILTER_SANITIZE_STRING) => $this->request->getPost('public_key12', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key13', FILTER_SANITIZE_STRING) => $this->request->getPost('public_key13', FILTER_SANITIZE_STRING)

                ));

                $private_key = serialize(array(

                    $this->request->getPost('key1', FILTER_SANITIZE_STRING)  => $this->request->getPost('private_key', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key2', FILTER_SANITIZE_STRING)  => $this->request->getPost('private_key2', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key3', FILTER_SANITIZE_STRING)  => $this->request->getPost('private_key3', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key4', FILTER_SANITIZE_STRING)  => $this->request->getPost('private_key4', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key5', FILTER_SANITIZE_STRING)  => $this->request->getPost('private_key5', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key6', FILTER_SANITIZE_STRING)  => $this->request->getPost('private_key6', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key7', FILTER_SANITIZE_STRING)  => $this->request->getPost('private_key7', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key8', FILTER_SANITIZE_STRING)  => $this->request->getPost('private_key8', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key9', FILTER_SANITIZE_STRING)  => $this->request->getPost('private_key9', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key10', FILTER_SANITIZE_STRING) => $this->request->getPost('private_key10', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key11', FILTER_SANITIZE_STRING) => $this->request->getPost('private_key11', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key12', FILTER_SANITIZE_STRING) => $this->request->getPost('private_key12', FILTER_SANITIZE_STRING),
                    $this->request->getPost('key13', FILTER_SANITIZE_STRING) => $this->request->getPost('private_key13', FILTER_SANITIZE_STRING)

                ));

                $data['payment_gateway']   = (object)$userdata = array(

    	            'id'            => $this->request->getPost('id', FILTER_SANITIZE_STRING),
    	            'agent'         => $this->request->getPost('agent', FILTER_SANITIZE_STRING),
    	            'public_key'    => $public_key,
    	            'private_key'   => $private_key,
    	            'status'        => $this->request->getPost('status')
    	        );

    			if ($this->common_model->update('payment_gateway',$userdata,array('id' =>  $this->request->getPost('id')))) {
    				$this->session->setFlashdata('message', display('update_successfully'));
    			} else {
    				$this->session->setFlashdata('exception', display('please_try_again'));
    			}
                return redirect()->to(base_url('backend/payment_gateway/gourl_setting'));

    		} else {

                $this->session->setFlashdata("exception", $this->validation->listErrors());
                return redirect()->route('backend/payment_gateway/gourl_setting');
            }
        }
		
		$data['content'] = $this->BASE_VIEW . '\Payment_gateway\form';
        return $this->template->admin_layout($data);
	}


	
}