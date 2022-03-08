<?php 
namespace App\Modules\Token\Libraries;

class Payment
{
    
    public function payment_process($sdata, $method=NULL){
        $this->session  = \Config\Services::session();
        $this->db       =  db_connect();
        $builder        = $this->db->table('payment_gateway');
        $gateway        = $builder->select('*')->where('identity', $method)->where('status', 1)->get()->getrow();
     
        if($method=='token'){

            /******************************
            * Mobile Payment (Manual)
            ******************************/            
            if ($gateway) {

                $data['approval_url'] = base_url('customer/payment_callback/token_confirm');
                $data['cancel_url']   = base_url('customer/payment_callback/token_cancel');
                
                return $data;

            } else {

                return false;

            }

        }
    }
}