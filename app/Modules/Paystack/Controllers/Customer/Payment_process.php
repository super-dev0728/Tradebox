<?php 
namespace App\Modules\Paystack\Controllers\Customer;

class payment_process extends BaseController
{

    public function paystack()
    {
       
        $data['title']  = display('deposit');
       
        if ($this->session->get('deposit')) {
            $data['deposit'] = $this->session->get('deposit');

            //Payment Type specify for callback (deposit/buy/sell etc )
            $this->session->set('payment_type', 'deposit');

            $method  = $data['deposit']->deposit_method;
            $data['deposit_data']   = $this->payment->payment_process($data['deposit'], $method);
            if (!$data['deposit_data']) {
                $this->session->setFlashdata('exception', display('this_gateway_deactivated'));
                return redirect()->to(base_url('deposit'));
            }

        }else if($this->session->userdata('buy')){
            $data['title']  = display('buy');
            $data['deposit'] = $this->session->userdata('buy');

            //Payment Type specify for callback (deposit/buy/sell etc )

            $method                 = $data['deposit']->deposit_method;
            $data['deposit_data']   = $this->payment->payment_process($data['deposit'], $method);
            if (!$data['deposit_data']) {
                $this->session->setFlashdata('exception', display('this_gateway_deactivated'));
                return redirect()->to(base_url('customer/buy/buy_form'));
            }
        } else {
            $this->session->setFlashdata('exception', "Something went wrong!!!");
            return redirect()->to(base_url('deposit'));
        }
        
        $data['page'] = $this->BASE_VIEW . '\payment_process';
        return $this->template->master($data);
    }
}