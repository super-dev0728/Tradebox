<?php 
namespace App\Modules\Token\Controllers\Admin;


class Payment_gateway extends BaseController
{
	
	public function form()
	{ 
		$data['title']  		= display('edit_payment_gateway');
		$pagewhere				= array('identity'=>'token');
		$data['payment_gateway']= $this->common_model->read('payment_gateway', $pagewhere);
		$data['countrys'] 		= $this->common_model->findAll('dbt_country', array(), 'id', 'asc', 300, 0);
		
		$this->validation->setRule('public_key', display('public_key'),'required|max_length[1000]');
        $this->validation->setRule('private_key', display('private_key'),'required|max_length[1000]');
		
		if ($this->request->getMethod() == 'post') {
			if ($this->validation->withRequest($this->request)->run()) 
			{

	            $public_key 	= $this->request->getPost('public_key', FILTER_SANITIZE_STRING);
	            $private_key	= $this->request->getPost('private_key', FILTER_SANITIZE_STRING);

				$id 	= $data['payment_gateway']->id;
	            $where  = array('id' => $id);

	            $data['payment_gateway']    = (object)$userdata = array(

		            'id'            => $this->request->getPost('id', FILTER_SANITIZE_STRING),
		            'agent'         => $this->request->getPost('agent', FILTER_SANITIZE_STRING),
		            'public_key'    => $public_key,
		            'private_key'   => $private_key,
		            'secret_key'    => "show",
		            'data'          => "",
		            'status'        => $this->request->getPost('status', FILTER_SANITIZE_STRING)
		        );
				if ($this->common_model->update('payment_gateway', $userdata, $where)) {

					$this->session->setFlashdata('message', display('update_successfully'));

				} else {

					$this->session->setFlashdata('exception', display('please_try_again'));
				}
	            return redirect()->to(base_url('backend/payment_gateway/token_setting'));

			}  else {

				$this->session->setFlashdata("exception", $this->validation->listErrors());
				return redirect()->route('backend/payment_gateway/token_setting');
			}
		}
		$data['content'] = $this->BASE_VIEW . '\Payment_gateway\form';
        return $this->template->admin_layout($data);
	}
}