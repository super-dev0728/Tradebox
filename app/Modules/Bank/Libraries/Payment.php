<?php 
namespace App\Modules\Bank\Libraries;

class Payment
{
    
    public function payment_process($sdata, $method=NULL){
        $this->session  = \Config\Services::session();
        $this->db       =  db_connect();
        $builder        = $this->db->table('payment_gateway');
        $gateway        = $builder->select('*')->where('identity', $method)->where('status', 1)->get()->getrow();
     
        if($method=='bank'){

            /******************************
            * Mobile Payment (Manual)
            ******************************/            
            if ($gateway) {

                $data['approval_url'] = base_url('customer/payment_callback/bank_confirm');
                
                return $data;

            } else {

                return false;

            }

        }
    }
}