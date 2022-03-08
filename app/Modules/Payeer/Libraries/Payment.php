<?php 
namespace App\Modules\Payeer\Libraries;

class Payment
{
    
    public function payment_process($sdata, $method=NULL){
        $this->session  = \Config\Services::session();
        $this->db       =  db_connect();
        $builder        = $this->db->table('payment_gateway');
        $gateway        = $builder->select('*')->where('identity', $method)->where('status', 1)->get()->getrow();  
        if ($method=='payeer') {

            /******************************
            * Payeer Payment Gateway API
            ******************************/
            if ( $gateway ) {

                $paytype = $this->session->userdata('payment_type');

                $date       = new \DateTime();
                $invoice    = $date->getTimestamp();
                $comment    = $invoice;

                $data['m_shop']     = @$gateway->public_key;
                $data['m_orderid']  = @$paytype.'_'.@$sdata->deposit_id.'_'.@$sdata->user_id.'_'.time();
                $data['m_amount']   = number_format((float)@$sdata->deposit_amount+(float)@$sdata->fees, 2, '.', '');
                $data['m_curr']     = 'USD';
                $data['m_desc']     = base64_encode($comment);
                $data['m_key']      = @$gateway->private_key;

                $arHash = array(
                    $data['m_shop'],
                    $data['m_orderid'],
                    $data['m_amount'],
                    $data['m_curr'],
                    $data['m_desc']
                );

                $arHash[] = $data['m_key'];

                $data['sign'] = strtoupper(hash('sha256', implode(':', $arHash)));

                return $data;
            }
            else{
                return false;
            }

        }

    }
}