<?php 
namespace App\Modules\Token\Controllers\Customer;

class payment_process extends BaseController
{
    
    public function token()
    {
       
        $data['title']  = display('deposit');
        
        if ($this->session->get('deposit')) {
            $data['deposit'] = $this->session->get('deposit');

            //Payment Type specify for callback (deposit/buy/sell etc )
            $this->session->set('payment_type', 'deposit');

            $method  = $data['deposit']->deposit_method;
            $data['deposit_data']   = $this->payment->payment_process($data['deposit'], $method);
            $data['gateway']        = $this->db->table('payment_gateway')->select('*')->where('identity', $method)->where('status', 1)->get()->getrow();

            if (!$data['deposit_data']) {
                $this->session->setFlashdata('exception', display('this_gateway_deactivated'));
                return redirect()->to(base_url('deposit'));
            }

        }else if($this->session->userdata('buy')){
           
        } else {
           
        }
        
        $data['page'] = $this->BASE_VIEW . '\payment_process';
        return $this->template->master($data);
    }
}