<?php namespace App\Modules\Finance\Controllers;

class Ajaxload extends BaseController 
{

    /*
    |---------------------------------
    |   Fees Load and deposit amount 
    |---------------------------------
    */
    public function fees_load()
    {   
        $amount = $this->request->getVar('amount',FILTER_SANITIZE_STRING); 
        $level = $this->request->getVar('level',FILTER_SANITIZE_STRING); 
        $builder = $this->db->table('fees_tbl');

        $result = $builder->select('fees')
                            ->where('level', $level)
                            ->get()
                            ->getRow();

        $fees = ($amount/100)*(float)@$result->fees;
        $new_amount = $amount-$fees;
        echo json_encode(array('fees'=> $fees, 'amount'=> $new_amount));    
    }


    /*
    |---------------------------------
    |   check Wallet Id
    |---------------------------------
    */
    public function walletid()
    {   
        $method = $this->request->getVar('method',FILTER_SANITIZE_STRING); 
        $user_id = $this->session->get('user_id'); 
        
        $builder = $this->db->table('payment_metod_setting');
        $result = $builder->select('*')
        ->where('method',$method)
        ->where('user_id',$user_id)
        ->get()
        ->getrow();
        echo json_encode($result);

    }
    /*
    |---------------------------------
    |   check reciver user Id
    |---------------------------------
    
*/
     public function checke_reciver_id()
    {   
        $receiver_id = $this->request->getVar('receiver_id',FILTER_SANITIZE_STRING); 
        if(!empty($receiver_id))
        {
            $result = $this->db->table('user_registration')->select('*')
                            ->where('user_id',$receiver_id)
                            ->countAllResults();
            echo $result;
        }
        
    }
}
