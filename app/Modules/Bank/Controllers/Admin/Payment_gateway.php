<?php 
namespace App\Modules\Bank\Controllers\Admin;


class Payment_gateway extends BaseController
{
	
	public function form()
	{ 
		$data['title']  = display('edit_payment_gateway');
		$pagewhere=array('identity'=>'bank');
		$data['payment_gateway']= $this->common_model->read('payment_gateway', $pagewhere);
		$data['countrys'] = $this->common_model->findAll('dbt_country', array(), 'id', 'asc', 300, 0);
		
		$this->validation->setRule('acc_name', display('account_name'), 'required|trim');
        $this->validation->setRule('acc_no', display('account_no'), 'required|trim');
        $this->validation->setRule('branch_name', display('branch_name'), 'required|trim');
        $this->validation->setRule('country', display('country'), 'required|trim');
        $this->validation->setRule('bank_name', display('bank_name'), 'required|trim');
        $this->validation->setRule('status', display('status'),'required|max_length[1000]');

        if ($this->request->getMethod() == 'post') {
		
			if ($this->validation->withRequest($this->request)->run()) 
			{

				$acc_name       = $this->request->getPost('acc_name', FILTER_SANITIZE_STRING);
	            $acc_no         = $this->request->getPost('acc_no', FILTER_SANITIZE_STRING);
	            $branch_name    = $this->request->getPost('branch_name', FILTER_SANITIZE_STRING);
	            $swift_code     = $this->request->getPost('swift_code', FILTER_SANITIZE_STRING);
	            $abn_no         = $this->request->getPost('abn_no', FILTER_SANITIZE_STRING);
	            $country        = $this->request->getPost('country', FILTER_SANITIZE_STRING);
	            $bank_name      = $this->request->getPost('bank_name', FILTER_SANITIZE_STRING);

	            $post_data 		= $this->request->getPost();
	            $public_key 	= json_encode($post_data);
	            $private_key	= $this->request->getPost('private_key', FILTER_SANITIZE_STRING);


				$id 	= $data['payment_gateway']->id;
	            $where  = array('id' => $id);

	            $data['payment_gateway']    = (object)$userdata = array(

		            'id'            => $this->request->getPost('id', FILTER_SANITIZE_STRING),
		            'agent'         => $this->request->getPost('agent', FILTER_SANITIZE_STRING),
		            'public_key'    => $public_key,
		            'private_key'   => $private_key,
		            'secret_key'    => $this->request->getPost('secret_key', FILTER_SANITIZE_STRING),
		            'data'          => "",
		            'status'        => $this->request->getPost('status', FILTER_SANITIZE_STRING)
		        );
				if ($this->common_model->update('payment_gateway', $userdata, $where)) {

					$this->session->setFlashdata('message', display('update_successfully'));

				} else {

					$this->session->setFlashdata('exception', display('please_try_again'));
				}
	            return redirect()->to(base_url('backend/payment_gateway/bank_setting'));

			} else {

				$this->session->setFlashdata("exception", $this->validation->listErrors());
                return redirect()->route('backend/payment_gateway/bank_setting');
			}
		} 
		
		$data['content'] = $this->BASE_VIEW . '\Payment_gateway\form';
        return $this->template->admin_layout($data);
	}
}