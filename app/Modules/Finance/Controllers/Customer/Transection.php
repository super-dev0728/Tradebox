<?php 
namespace App\Modules\Finance\Controllers\Customer;

class Transection extends BaseController 
{

    public function index()
    { 

        $data = $this->transfer_model->get_cata_wais_transections();
        $where = array(
            'user_id' => $this->session->userdata('user_id') 
        );
        $data['transection'] = $this->common_model->get_all('transections',$where,$limit=null,$offset=null,'transection_id','DESC');
        $data['title']   = display('transection');
        
        $data['content'] = $this->BASE_VIEW . '\transection';
        return $this->template->customer_layout($data);
        
    }

}
